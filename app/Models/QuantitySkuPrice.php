<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuantitySkuPrice extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    // A quien aplica el precio
    const PRODUCT = 1;
    const QUANTITY = 2;
}
