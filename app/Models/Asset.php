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
        'level_number',
        'type',
        'area',
        'units',
        'description',
        'status'
    ];
}