<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CategoriaEntidad;

class CategoriaEntidadController extends Controller
{
    public function index()
    {      
        $categorias_entidad = CategoriaEntidad::all();

        return $categorias_entidad;
    }

    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $request->validate([
            'nombre' => 'required|max:30',
            'categoria_id' => 'required'
        ]);
        
        $categoria_entidad = new CategoriaEntidad();
        
        $categoria_entidad->nombre          = strtoupper($request->nombre);
        $categoria_entidad->descripcion     = strtoupper($request->descripcion);
        $categoria_entidad->categoria_id    = $request->categoria_id;

        $categoria_entidad->save();

        return $categoria_entidad;
    }

    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $request->validate([
            'nombre' => 'required|max:30',
            'categoria_id' => 'required'
        ]);
       
        $categoria_entidad = CategoriaEntidad::findOrFail($request->cat_ent_id);

        $categoria_entidad->nombre          = strtoupper($request->nombre);
        $categoria_entidad->descripcion     = strtoupper($request->descripcion);
        $categoria_entidad->categoria_id    = $request->categoria_id;

        $categoria_entidad->save();

        return $categoria_entidad;
    }

    public function edit(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        return CategoriaEntidad::find($request->cat_ent_id);
    }

}
