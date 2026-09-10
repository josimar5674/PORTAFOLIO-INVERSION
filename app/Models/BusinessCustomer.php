<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\BusinessCustomerNote;

class BusinessCustomer extends Model
{
    protected $fillable = [

        'nombre',
        'identificador_tributario',
        'email',
        'telefono'

    ];



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


public function users()
{
    return $this->belongsToMany(
        \App\Models\User::class,
        'user_business_customer'
    )->withTimestamps();
}

public function alertas()
{
    return $this->morphMany(
        Alert::class,
        'alertable'
    );
}    
}