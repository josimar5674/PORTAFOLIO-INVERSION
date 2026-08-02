<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use App\Models\Inversion;
use App\Models\Entidad;

class Cliente extends Model
{
    protected $fillable = [
        'nombre',
        'tipo',
        'telefono',
        'email'
    ];

    public function inversiones()
    {
        return $this->belongsToMany(
            Inversion::class,
            'inversion_cliente'
        );
    }

    public function entidades()
    {
        return $this->belongsToMany(
            Entidad::class,
            'cliente_entidad'
        );
    }

    public function identificaciones()
    {
        return $this->hasMany(
            ClienteIdentificacion::class
        );
    }

    public function nacionalidades()
    {
        return $this->hasMany(
            ClienteNacionalidad::class
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

public function entidad()
{
    return $this->belongsToMany(
        Entidad::class,
        'entidad_socios'
    )->withPivot('porcentaje')
     ->withTimestamps();
}

    
}