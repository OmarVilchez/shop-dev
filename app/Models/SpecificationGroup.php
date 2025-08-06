<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SpecificationGroup extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = ['id', 'active'];

    protected $casts = [
        'active' => 'boolean',
    ];

    // Relacion de uno a muchos
    public function specifications()
    {
        return $this->hasMany(Specification::class);
    }
}
