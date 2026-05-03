<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
protected $fillable = [
    'inversion_id',
    'clave',
    'prestador',
    'categoria',
    'servicio',
    'relacion',
    'costo_mensual',
    'costo_anual'
];

    public function inversion()
    {
        return $this->belongsTo(Inversion::class);
    }
}