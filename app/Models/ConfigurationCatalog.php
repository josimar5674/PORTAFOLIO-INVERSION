<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConfigurationCatalog extends Model
{
    protected $fillable = [

        'name',

        'description',

        'active',

    ];


    protected $casts = [

        'active' => 'boolean',

    ];


    /*
    |--------------------------------------------------------------------------
    | OPCIONES DEL CATÁLOGO
    |--------------------------------------------------------------------------
    */

    public function options()
    {
        return $this->hasMany(
            ConfigurationOption::class,
            'catalog_id'
        );
    }
}