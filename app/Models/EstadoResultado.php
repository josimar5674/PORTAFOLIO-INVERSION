<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstadoResultado extends Model
{
    protected $table = 'estado_resultados';

    protected $fillable = [
        'inversion_id',
        'anio',

        'ingresos',
        'costos',
        'otros_gastos',

        'noi',

        'depreciacion',

        'ebit',

        'gasto_financiero',

        'ebt',

        'impuestos',

        'utilidad_neta'
    ];

    public function inversion()
    {
        return $this->belongsTo(Inversion::class);
    }
}