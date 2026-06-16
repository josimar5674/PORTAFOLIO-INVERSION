<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClienteIdentificacion extends Model
{
    protected $table = 'cliente_identificaciones';

    protected $fillable = [
        'cliente_id',
        'tipo',
        'numero'
    ];

    public function cliente()
    {
        return $this->belongsTo(
            Cliente::class
        );
    }
}