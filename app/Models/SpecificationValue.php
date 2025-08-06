<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SpecificationValue extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = ['id', 'active'];

    protected $cast = [
        'active' => 'boolean'
    ];

    // Relacion de uno a muchos
    public function specificationAssociations()
    {
        return $this->hasMany(SpecificationAssociation::class);
    }
    // Relacion de uno a muchos inversa
    public function specification()
    {
        return $this->belongsTo(Specification::class);
    }
}
