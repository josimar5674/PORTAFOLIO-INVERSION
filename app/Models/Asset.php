<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Comercial;

class Asset extends Model
{


protected $fillable = [

    'investment_id',

    'producto_id',

    'name',

    'category',

    'brand',

    'model',

    'serial_number',

    'asset_code',

    'purchase_date',

    'purchase_value',

    'sale_value',

    'useful_life',

    'description',

    'status',

];

protected $casts = [

    'purchase_date' => 'date',

    'purchase_value' => 'decimal:2',

    'sale_value' => 'decimal:2',

    'useful_life' => 'integer',

    'status' => 'boolean',

];

public function inversiones()
{
    return $this->belongsTo(\App\Models\Inversion::class, 'investment_id');
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

public function producto()
    {
        return $this->belongsTo(Comercial::class, 'producto_id');
    }


    
}