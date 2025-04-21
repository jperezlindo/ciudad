<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Localidad extends Model
{
    protected $table = 'localidades';

    protected $guarded = [];

    public function entidades()
    {
        return $this->hasMany('App\Entidad');
    }
}
