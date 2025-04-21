<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Producto extends Model
{
    protected $table = 'productos';

    protected $guarded = [];

    public function entidad()
    {
        return $this->belongsTo('App\Entidad');
    }

    public function scopeBuscar ($query, $buscar)
    {
        return $query
                    ->where('codigo', '=', $buscar)
                    ->orWhere('nombre', 'LIKE', "%$buscar%")
                    ->orWhere('marca', 'LIKE', "%$buscar%");
    }
}
