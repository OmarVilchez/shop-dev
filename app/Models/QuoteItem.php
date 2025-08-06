<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuoteItem extends Model
{
    use HasFactory;


    protected $guarded = ['id', 'created_at', 'updated_at'];

    // Relacion uno a muchos inversa
    public function quote()
    {
        return $this->belongsTo(Quote::class);
    }

    public function stockKeepingUnit()
    {
        return $this->belongsTo(StockKeepingUnit::class);
    }
}
