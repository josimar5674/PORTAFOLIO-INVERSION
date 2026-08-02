<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\BusinessCustomer;

class Comercial extends Model
{
    protected $table = 'comercial';

    protected $fillable = [
        'inversion_id',
        'producto',
        'cliente',
        'cliente_id',
        'cantidad',
        'unidad',
        'precio_unitario',
        'subtotal'
    ];

    public function inversion()
    {
        return $this->belongsTo(Inversion::class);
    }



    public function activos()
    {
        return $this->hasMany(Asset::class, 'producto_id');
    }




public function business_customer()
{
    return $this->belongsTo(BusinessCustomer::class, 'cliente_id');
}
}