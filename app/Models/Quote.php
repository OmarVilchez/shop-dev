<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    use HasFactory;

    const CLIENT_TYPE = [
        'person' => 'Persona',
        'company' => 'Empresa',
    ];

    const STATUS = [
        'draft' => 'Borrador',
        'sent' => 'Enviado',
        'accepted' => 'Aceptado',
        'rejected' => 'Rechazado',
    ];

    protected $guarded = ['id', 'status'];

    // Relaciones
    public function Quoteitems()
    {
        return $this->hasMany(QuoteItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // URL amigable
    public function getRouteKeyName()
    {
        return 'quote_number';
    }
}
