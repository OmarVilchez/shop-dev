<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'internal_id',
        'name',
        'trade_name',
        'slug',
        'category_id',
        'description',
        'description_short',
        'meta_title',
        'meta_description',
        'keywords',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    // relacion de uno a muchos inversa
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relacion de uno a muchos
    public function stockKeepingUnits()
    {
        return $this->hasMany(StockKeepingUnit::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // Relacion muchos a muchos
    public function collection()
    {
        return $this->belongsToMany(Collection::class)->withTimestamps();
    }

    public function SpecificationAssociations()
    {
        return $this->hasMany(SpecificationAssociation::class);
    }


    // Scopes
    public function scopeActive($query)
    {
        return $query->where('products.active', 1);
    }

 /*    public function scopeLike($query, $field, $value)
    {
        return $query->where($field, 'LIKE', "%$value%");
    }

    public function scopeFirstSku($query)
    {
        return $this->stockKeepingUnits()->where('active', 1)->first();
    }

    public function scopeWhereSkuSlug($query, $slug)
    {
        return $this->StockKeepingUnits()
            ->where('slug', $slug)
            ->active()
            ->first();
    }

    public function scopeFirstSkuImage($query)
    {
        return $this->stockKeepingUnits()
            ->where('active', 1)
            ->orderBy('created_at', 'asc')
            ->first()
            ->images()->first();
    }
 */

    // URL amigable
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
