<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\AlertRecipient;

class Alert extends Model
{
    protected $fillable = [

        'alertable_type',
        'alertable_id',

        'fecha',
        'hora',
        'recurrencia',
        'asunto',

        'next_run_at',

        'mensaje',
        'metadata',

        'active',

        'created_by',

    ];


    protected $casts = [

        'fecha' => 'date',

        'next_run_at' => 'datetime',

        'metadata' => 'array',

        'active' => 'boolean',

    ];


    /*
    |--------------------------------------------------------------------------
    | MODELO AL QUE PERTENECE
    |--------------------------------------------------------------------------
    */

    public function alertable()
    {
        return $this->morphTo();
    }


    /*
    |--------------------------------------------------------------------------
    | USUARIOS DESTINATARIOS
    |--------------------------------------------------------------------------
    */

    public function usuarios()
    {
        return $this->belongsToMany(
            User::class,
            'alert_user'
        )->withPivot([
            'sent_at',
            'status',
            'error',
        ])->withTimestamps();
    }


    /*
    |--------------------------------------------------------------------------
    | USUARIO QUE CREÓ LA ALERTA
    |--------------------------------------------------------------------------
    */

    public function creador()
    {
        return $this->belongsTo(
            User::class,
            'created_by'
        );
    }

    public function destinatarios()
{
    return $this->hasMany(AlertRecipient::class);
}
}