<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Announcement extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = ['id', 'active'];

    protected $casts = [
        'date_from' => 'datetime',
        'date_to' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    const INFO = 1;
    const TIMER = 2;

    public function scopeActive($query)
    {
        return $query->where('active', true)->where(function ($query) {
            $query->where([['date_from', '<=', now()], ['date_to', '>=', now()]]);
        })->orWhere(function ($query) {
            $query->whereNull('date_from')
                ->whereNull('date_to');
        })->orderBy('position', 'desc');
    }
}
