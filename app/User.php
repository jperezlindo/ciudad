<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function entidad()
    {
        return $this->belongsTo('App\Entidad');
    }

    public function scopeBuscar ($query, $buscar)
    {
        if ($buscar)
            return $query
                ->where('dni', 'LIKE', "%$buscar%")
                ->orWhere('apellido', 'LIKE', "%$buscar%")
                ->orWhere('email', 'LIKE', "%$buscar%")
                ->orWhere('nombre', 'LIKE', "%$buscar%");
    }
}
