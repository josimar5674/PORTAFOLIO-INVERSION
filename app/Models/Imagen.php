<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Imagen extends Model
{
    protected $table = 'imagenes';

    protected $fillable = [
        'imageable_type',
        'imageable_id',
        'ruta',
        'nombre_original',
        'descripcion',
        'orden',
    ];

    public function imageable()
    {
        return $this->morphTo();
    }
}