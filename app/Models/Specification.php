<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Specification extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = ['id', 'active'];

    protected $casts = [
        'active' => 'boolean',
    ];

    // Relacion uno a muchos
    public function specificationValues()
    {
        return $this->hasMany(SpecificationValue::class);
    }

    public function specificationAssociations()
    {
        return $this->hasMany(SpecificationAssociation::class);
    }

    // Relacion uno a muchos inversa
    public function specificationGroup()
    {
        return $this->belongsTo(SpecificationGroup::class);
    }

    public function fieldType()
    {
        return $this->belongsTo(FieldType::class);
    }
}
