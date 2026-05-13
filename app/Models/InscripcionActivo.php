<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InscripcionActivo extends Model
{
    protected $table = 'inscripcion_activos';

    protected $fillable = [
        'activo_registral_id',
        'fecha',
        'acto',
        'inscripcion',
        'descripcion',
        'digitalizacion'
    ];

    public function activoRegistral()
    {
        return $this->belongsTo(ActivoRegistral::class);
    }
}