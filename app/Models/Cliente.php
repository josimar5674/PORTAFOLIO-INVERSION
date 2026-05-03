<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
public function inversiones()
{
    return $this->belongsToMany(Inversion::class, 'inversion_cliente');
}

protected $fillable = [
    'nombre',
    'tipo', 
    'identificacion',
    'telefono',
    'email',
    'nacionalidad',
    'agente_nombre',
    'agente_email',
    'agente_numero_id',
    'agente_movil',
    'agente_tipo_id'
];

}
