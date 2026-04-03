<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Avaluo extends Model
{
    protected $table = 'avaluos';

    protected $fillable = [
        'inversion_id',
        'valor_terreno',
        'valor_construccion',
        'valor_total',
        'fecha_avaluo',
        'observaciones'
    ];

    public function inversion()
    {
        return $this->belongsTo(Inversion::class);
    }
}