<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    public function inversiones()
{
    return $this->hasMany(Inversion::class);
}

protected $fillable = [
    'nombre',
    'tipo',
    'identificacion',
    'telefono',
    'email'
];

}
