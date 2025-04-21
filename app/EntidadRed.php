<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EntidadRed extends Model
{
    protected $table = 'entidad_redes';

    public function red()
    {
        return $this->belongsTo('App\Red');
    }
}
