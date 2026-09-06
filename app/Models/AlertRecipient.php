<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlertRecipient extends Model
{
    protected $fillable = [
        'alert_id',
        'type',
        'recipient_id',
        'name',
        'email',
        'sent_at',
        'status',
        'error',
    ];

    protected $casts = [
        'sent_at' => 'datetime',
    ];

    public function alert()
    {
        return $this->belongsTo(Alert::class);
    }
}