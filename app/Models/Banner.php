<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    // La propiedad $guarded define los campos que no se pueden asignar masivamente
    protected $guarded = ['id', 'active'];

    //La propiedad $casts se utiliza para indicar a Laravel cómo deben tratarse ciertos campos al recuperarlos de la base de datos
    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'active' => 'boolean',
    ];
}
