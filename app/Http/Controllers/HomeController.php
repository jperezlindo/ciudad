<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;

use App\Entidad;
use App\Localidad;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('guest', ['except' => array('index')]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {   
        $version = rand();

        return view('index', compact('version'));
    }

    public function localidades(Request $request)
    {
        //if (!$request->ajax()) return redirect('/');

        $localidades = Localidad::has('entidades')->get();

        return $localidades;
    }

    public function getProvincias(Request $request)
    {

        if (!$request->ajax()) return redirect('/');

        return DB::table('provincias')->get();
    }

    public function getLocalidades(Request $request)
    {

        if (!$request->ajax()) return redirect('/');

        if ($request->buscar){
            return DB::table('localidades')->where('nombre', 'LIKE' ,"%$request->buscar%")->get();
        }

        return DB::table('localidades')->where('provincia_id', $request->provincia_id)->get();
    }

    public function getComercios(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $categorias_entidad = DB::table('categorias_entidad')->where('categoria_id', 1)->orderBy('nombre')->get();
        $entidades = DB::table('entidades')->where('localidad_id', $request->localidad_id)->get();
        
        $comercios = new Collection();

        foreach ($categorias_entidad as $ce )
        {
            if ($entidades->contains('categoria_entidad_id', $ce->id))
            {
                $comercios->push($ce);
            }
        }

        return $comercios;

    }

    public function getServicios(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $categorias_entidad = DB::table('categorias_entidad')->where('categoria_id', 2)->orderBy('nombre')->get();
        $entidades = DB::table('entidades')->where('localidad_id', $request->localidad_id)->get();
        
        $servicios = new Collection();

        foreach ($categorias_entidad as $ce )
        {
            if ($entidades->contains('categoria_entidad_id', $ce->id))
            {
                $servicios->push($ce);
            }
        }

        return $servicios;  
    }

    public function getTurismo(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $categorias_entidad = DB::table('categorias_entidad')->where('categoria_id', 3)->orderBy('nombre')->get();
        $entidades = DB::table('entidades')->where('localidad_id', $request->localidad_id)->get();
        
        $turismo = new Collection();

        foreach ($categorias_entidad as $ce )
        {
            if ($entidades->contains('categoria_entidad_id', $ce->id))
            {
                $turismo->push($ce);
            }
        }

        return $turismo;    
    }

    public function getResto(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        
        $categorias_entidad = DB::table('categorias_entidad')->where('categoria_id', 4)->orderBy('nombre')->get();
        $entidades = DB::table('entidades')->where('localidad_id', $request->localidad_id)->get();
        
        $resto = new Collection();

        foreach ($categorias_entidad as $ce )
        {
            if ($entidades->contains('categoria_entidad_id', $ce->id))
            {
                $resto->push($ce);
            }
        }

        return $resto;   
    }

    public function terminos()
    {
        return view('terminos');
    }

    public function planes()
    {
        return view('planes');
    }

}
