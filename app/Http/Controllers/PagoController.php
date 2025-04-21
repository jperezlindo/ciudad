<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

use App\Pago;
use App\Entidad;

class PagoController extends Controller
{
    public function __contruct(){
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        //if (!$request->ajax()) return redirect('/');

        $ents = Entidad::all();
        $entidades = new Collection();
        foreach ($ents as $ent){
            $pago = Pago::where('entidad_id', $ent->id)->get()->last();
            if ($pago){
                $entidad = new Collection();
                $entidad->put('entidad', $ent);
                $entidad->put('id_pago', $pago->id);
                $entidad->put('precio_pago', $pago->precio);
                $entidad->put('ultimo_pago', $pago->created_at->format('d-m-Y'));
                
                $entidad->put('proximo_pago', $pago->created_at->modify("+1 month")->format('d-m-Y'));
    
                $entidades->push($entidad);
            }
        }
        return $entidades;
    }

    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $pago = new Pago();

        $pago->entidad_id = $request->entidad_id;
        $pago->precio = $request->precio;
        $pago->comentario = $request->comentario;

        $pago->save();

        return 'En pago se realizo con exito.';

    }
}
