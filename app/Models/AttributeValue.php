<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttributeValue extends Model
{
   use HasFactory;

   protected $fillable = [
       'attribute_id',
       'value',
       'slug',
       'image',
       'position',
       'active'
   ];

   protected $casts = [
         'active' => 'boolean',
   ];

    //relacion de uno a muchos
    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }

    // Relacion de muchos a muchos con StockKeepingUnit
    public function stockKeepingUnits()
    {
        return $this->belongsToMany(StockKeepingUnit::class, 'sku_attribute_values')
            ->withPivot('attribute_id')
            ->withTimestamps();
    }

    //URL amigable
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
