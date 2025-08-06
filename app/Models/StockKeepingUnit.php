<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StockKeepingUnit extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'product_id',
        'internal_id',
        'name',
        'trade_name',
        'description',
        'slug',
        'active',
        'is_default',
        'stock_quantity'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'active' => 'boolean',
    ];

    // Relación uno a muchos inversa
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    //relacion de muchos a muchos
    public function attributeValues()
    {
        return $this->belongsToMany(AttributeValue::class, 'sku_attribute_values')
            ->withPivot('attribute_id')
            ->withTimestamps();
    }

    // Relación uno a muchos
    public function specificationAssociations()
    {
        return $this->hasMany(SpecificationAssociation::class);
    }

    // Relación uno a muchos polimorfica
    public function images()
    {
        return $this->morphMany(Image::class, 'imageable')->orderBy('position', 'asc');
    }

    // Relación muchos a muchos
    public function quantities()
    {
        return $this->belongsToMany(Quantity::class, 'quantity_sku_prices')
            ->withPivot('cost_price', 'markup', 'base_price')
            ->wherePivot('apply_to', 2)
            ->withTimestamps();
    }

    public function promotions()
    {
        return $this->belongsToMany(Promotion::class, 'quantity_sku_promotion')
            ->withPivot('quantity_id')
            ->withTimestamps();
    }


    // Scope active
    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function scopeFirstServicePriceBase()
    {
        $base_price = $this->quantities()->active()->orderBy('position', 'asc')->first()->pivot->base_price;
        return $base_price;
    }

    public function scopeFirstQuantity($query)
    {
        return $this->quantities()->active()->orderBy('position', 'asc')->first();
    }

    // Scope para validar si existe promociones del sku y quantity
    public function scopeHasPromotionsQuantity($query, $quantity_id)
    {
        $promotions = $this->promotions()
            ->where([['date_from', '<=', now()], ['date_to', '>=', now()]])
            ->where('apply_to', 2)
            ->where('active', true)
            ->latest()
            ->wherePivot('quantity_id', $quantity_id)->get();

        return $promotions->count() > 0;
    }

    // Scope para obtener la promocion del sku
    public function scopeDiscountedPriceQuantity($query, $quantity_id)
    {
        return $this->promotions()
            ->where([['date_from', '<=', now()], ['date_to', '>=', now()]])
            ->where('apply_to', 2)
            ->where('active', true)
            ->latest()
            ->wherePivot('quantity_id', $quantity_id)->first();
    }

    // URL amigable
    public function getRouteKeyName()
    {
        return 'slug';
    }

}
