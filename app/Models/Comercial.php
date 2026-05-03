<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comercial extends Model
{
    protected $table = 'comercial'; // o comercial_detalle si lo separas

    protected $fillable = [
        'inversion_id',
        'producto',
        'cliente',
        'cantidad',
        'unidad',
        'precio_unitario',
        'subtotal'
    ];

    public function inversion()
    {
        return $this->belongsTo(Inversion::class);
    }

    public function comercial()
{
    return $this->hasMany(\App\Models\Comercial::class);
}
}