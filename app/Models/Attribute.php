<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'field_type_id',
        'is_variantable',
        'active'
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    public function fieldType()
    {
        return $this->belongsTo(FieldType::class);
    }

    public function values()
    {
        return $this->hasMany(AttributeValue::class);
    }

    //URL amigable
    public function getRouteKeyName(){
        return 'slug';
    }
}
