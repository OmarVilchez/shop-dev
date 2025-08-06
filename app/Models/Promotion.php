<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'active'];

    protected $casts = [
        'date_from' => 'datetime',
        'date_to' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'active' => 'boolean',
    ];

    // Tipo de promociones
    const PERCENTAGE = 1;
    const FIXED_AMOUNT = 2;

    // A quien aplica a la promocion
    const PRODUCT = 1;
    const SERVICE = 2;

    protected function conditionData(): Attribute
    {
        return Attribute::make(
            get: fn($value) => json_decode($value, true),
            set: fn($value) => json_encode($value),
        );
    }

    // Relación muchos a muchos inversa
    public function stockKeepingUnits()
    {
        return $this->belongsToMany(StockKeepingUnit::class, 'quantity_sku_promotion')->withPivot('quantity_id')->withTimestamps();
    }

    public function quantities()
    {
        return $this->belongsToMany(Quantity::class, 'quantity_sku_promotion')->withPivot('stock_keeping_unit_id')->withTimestamps();
    }
}
