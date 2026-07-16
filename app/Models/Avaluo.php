<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Inversion;


class Avaluo extends Model
{
    protected $table = 'avaluos';

protected $fillable = [
    'inversion_id',

    'area_terreno',
    'precio_terreno',
    'subtotal_terreno',
    'unidad_terreno',

    'area_construccion',
    'precio_construccion',
    'subtotal_construccion',

    'vida_util',
    'depreciacion',

    'valor_total',

    // 👇 IMPORTANTES
    'fecha_avaluo',
    'observaciones',
];

    public function inversion()
    {
        return $this->belongsTo(Inversion::class);
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