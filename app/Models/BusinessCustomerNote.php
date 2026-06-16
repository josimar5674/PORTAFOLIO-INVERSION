<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusinessCustomerNote extends Model
{
    protected $fillable = [

        'business_customer_id',

        'nota'

    ];

    public function cliente()
    {
        return $this->belongsTo(
            BusinessCustomer::class,
            'business_customer_id'
        );
    }
}