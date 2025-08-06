<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FieldType extends Model
{
    use HasFactory;

    protected $fillable = ['type', 'active'];

    protected $casts = [
        'active' => 'boolean',
    ];

    // Relacion uno a muchos
    public function attributes()
    {
        return $this->hasMany(Attribute::class);
    }

    public function specifications()
    {
        return $this->hasMany(Specification::class);
    }

}
