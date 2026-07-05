<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    // Relación: un activo pertenece a una inversión
    public function inversion()
    {
        return $this->belongsTo(Inversion::class, 'investment_id');
    }

protected $fillable = [

    'investment_id',

    'name',

    'category',

    'brand',

    'model',

    'serial_number',

    'asset_code',

    'purchase_date',

    'purchase_value',

    'useful_life',

    'description',

    'status',

];

public function inversiones()
{
    return $this->belongsTo(\App\Models\Inversion::class, 'investment_id');
}
}