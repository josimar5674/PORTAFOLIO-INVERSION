<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{


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