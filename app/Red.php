<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Red extends Model
{
    protected $table = 'redes';

    protected $guarded = [];

    public function entidad_redes()
    {
        return $this->hasMany('App\EntidadRed');
    }
}
