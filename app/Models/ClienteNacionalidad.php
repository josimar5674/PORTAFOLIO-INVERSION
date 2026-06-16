<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClienteNacionalidad extends Model
{
    protected $table = 'cliente_nacionalidades';

    protected $fillable = [
        'cliente_id',
        'pais'
    ];

    public function cliente()
    {
        return $this->belongsTo(
            Cliente::class
        );
    }
}