<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    protected $fillable = [
        'inversion_id',
        'nombre',
        'costo_mensual',
        'tipo',
        'descripcion'
    ];

    public function inversion()
    {
        return $this->belongsTo(Inversion::class);
    }
}