<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Collection extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'type_collection_id',
        'name',
        'description',
        'slug',
        'meta_title',
        'meta_description',
        'keywords',
        'thumbnail',
        'img_desktop',
        'img_mobile',
        'position',
        'active',
        'date_from',
        'date_to',
    ];

    protected $casts = [
        'active' => 'boolean',
        'date_from' => 'datetime',
        'date_to' => 'datetime',
    ];


    //Relacion uno a muchos inversa
    public function typeCollection()
    {
        return $this->belongsTo(TypeCollection::class);
    }

    // Relacion muchos a muchos
    public function products()
    {
        return $this->belongsToMany(Product::class)->withTimestamps();
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    // URL amigable
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
