<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SectionQuestion extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    // Relación uno a muchos
    public function frequentQuestions()
    {
        return $this->hasMany(FrequentQuestion::class)->orderBy('position', 'ASC');
    }
}
