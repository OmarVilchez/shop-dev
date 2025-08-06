<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FrequentQuestion extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = ['id'];

    //Relación uno a muchos inversa
    public function sectionQuestion()
    {
        return $this->belongsTo(SectionQuestion::class);
    }
}
