<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Quantity extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = ['id', 'active'];

    protected $casts = [
        'active' => 'boolean',
    ];

    // Relación muchos a muchos inversa
    public function stockKeepingUnits()
    {
        return $this->belongsToMany(StockKeepingUnit::class, 'quantity_sku_prices')->withTimestamps();
    }

    public function promotions()
    {
        return $this->belongsToMany(Promotion::class, 'quantity_sku_promotion')->withTimestamps();
    }

    // Scope active
    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function scopeBasePrice($query)
    {
        return $this->pivot->base_price;
    }
}
