<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;


#[Fillable(['name', 'email', 'password', 'role'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function isAdmin()
{
    return $this->role === 'admin';
}

public function inversiones()
{
    return $this->belongsToMany(
        \App\Models\Inversion::class,
        'user_inversion'
    );
}

public function tienePermiso($inversionId, $modulo)
{
    if ($this->role == 'admin')
    {
        return true;
    }

    $permiso = DB::table('user_inversion_modulos')
        ->where('user_id', $this->id)
        ->where('inversion_id', $inversionId)
        ->first();

    if (!$permiso)
    {
        return false;
    }

    return (bool) ($permiso->$modulo ?? false);
}

}
