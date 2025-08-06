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

    // Relacion de uno a muchos
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /* los query scopes facilita la creación de consultas SQL complejas que en algunos casos se pueden volver a aplicar la misma condición a otros modelos dentro de tu aplicación

    Para definir y usar correctamente los query scope, debemos seguir algunas reglas:

    Todos los scopes deben recibir la variable $query.
    Todos los nombres de los scopes deben comenzar con la palabra scope seguido del nombre que queremos llamarlo.
    */

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
