<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SkuAttributeValue extends Model
{
    use HasFactory;

    protected $fillable = [
        'stock_keeping_unit_id',
        'attribute_id',
        'attribute_value_id'
    ];

    //relacion de uno a muchos
    public function StockKeepingUnit()
    {
        return $this->belongsTo(StockKeepingUnit::class, 'stock_keeping_unit_id');
    }

    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }

    public function attributeValue()
    {
        return $this->belongsTo(AttributeValue::class);
    }
}
