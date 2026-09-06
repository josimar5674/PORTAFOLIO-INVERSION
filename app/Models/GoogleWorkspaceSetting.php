<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GoogleWorkspaceSetting extends Model
{
    protected $table = 'google_workspace_settings';

    protected $fillable = [
        'email',
        'client_id',
        'client_secret',
        'refresh_token',
        'connected_at',
        'active',
    ];

    protected $casts = [
        'connected_at' => 'datetime',
        'active' => 'boolean',
    ];

    protected $hidden = [
        'client_secret',
        'refresh_token',
    ];
}