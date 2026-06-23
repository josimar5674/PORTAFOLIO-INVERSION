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

    public function notas()
    {
        return $this->hasMany(
            BusinessCustomerNote::class,
            'business_customer_id'
        );
    }

    public function documentos()
{
    return $this->morphMany(
        Document::class,
        'documentable'
    );
}
}