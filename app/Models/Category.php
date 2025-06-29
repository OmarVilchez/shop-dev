<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /** @use HasFactory<\Database\Factories\CategoryFactory> */
    use HasFactory;

    //habilitamos asignacion masiva para los campos
    /*   protected $fillable = [
        'name',
        'title',
        'description',
        'slug',
        'meta_title',
        'meta_description',
        'image_desktop',
        'keywords',
        'position',
        'active',
    ]; */


    protected $guarded = ['id', 'active'];

    protected $casts = [
        'active' => 'boolean',
    ];

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

}
