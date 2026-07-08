<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Entidad extends Model
{
    protected $table = 'entidades';

    protected $fillable = [
        'inversion_id',
        'identificador_tributario',
        'tipo_societario',
        'matricula',
        'registro',
        'notario',
        'instrumento',
        'denominacion_social',
        'capital_social_min',
        'capital_social_max',
        'fecha_constitucion',
        'fecha_inscripcion',
        'inscripcion',
        'gerente_general',
        'subgerente_general',
        'comisario',
        'digitalizacion',
        'es_entidad',
        'es_apnfd'
    ];

  



    public function inversion()
{
    return $this->belongsToMany(
        Inversion::class,
        'entidad_inversion'
    );
}

public function inversiones()
{
    return $this->belongsToMany(
        \App\Models\Inversion::class,
        'entidad_inversion'
    );
}
public function documentos()
{
    return $this->morphMany(
        Document::class,
        'documentable'
    );
}

public function notas()
{
    return $this->morphMany(
        Note::class,
        'notable'
    );
}
}