<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivoRegistral extends Model
{
    protected $table = 'activo_registrals';

    protected $fillable = [
        'inversion_id',
        'ubicacion_inmueble',
        'ciudad',
        'numero_matricula',
        'valor_escrituracion',
        'clave_catastral_ip',
        'clave_catastral_municipal',
        'zonificacion',
        'digitalizacion'
    ];

    public function inversion()
    {
        return $this->belongsTo(Inversion::class);
    }

    public function inscripciones()
    {
        return $this->hasMany(InscripcionActivo::class);
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