<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeCollection extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'active'];

    protected $cast = [
        'active' => 'boolean',
    ];


    //Relación uno a muchos
    public function collections()
    {
        return $this->hasMany(Collection::class)->orderBy('name', 'ASC');
    }

    // Scope active
    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
