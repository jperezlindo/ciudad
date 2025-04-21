<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoriaEntidad extends Model
{
    protected $table = 'categorias_entidad';


    public function entidades()
    {
        return $this->hasMany('App\Entidad');
    }
}
