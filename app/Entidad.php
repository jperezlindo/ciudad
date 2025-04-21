<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\CategoriaEntidad;

class Entidad extends Model
{
    protected $table = 'entidades';
    
    protected $guarded = [];
    
    public function users()
    {
        return $this->hasMany('App\User');
    }

    public function categoriaEntidad()
    {
        return $this->belongsTo('App\CategoriaEntidad');
    }

    public function localidad()
    {
        return $this->belongsTo('App\Localidad');
    }

    public function productos()
    {
        return $this->hasMany('App\Producto');
    }


    public function scopeBuscar ($query, $buscar)
    {       
        if ($buscar){           
            return $query
                ->where('cuit', 'LIKE', "%$buscar%")
                ->orWhere('nombre', 'LIKE', "%$buscar%")
                ->orWhere('email', 'LIKE', "%$buscar%");
        }            
    }

    public function scopebuscarInvitado ($query, $buscar, $ce_id)
    {       
        
        if ($ce_id != 0){
            
            if ($buscar){
                return $query
                        ->where('categoria_entidad_id', '=', $ce_id)
                        ->where('nombre', 'LIKE', "%$buscar%")
                        ->orWhere('descripcion', 'LIKE', "%$buscar%");
            }       
            
            return $query
            ->where('categoria_entidad_id', '=', $ce_id);      

        }
        
        if ($buscar){
            return $query
                    ->where('nombre', 'LIKE', "%$buscar%")
                    ->orWhere('descripcion', 'LIKE', "%$buscar%");
        }
    }

}
