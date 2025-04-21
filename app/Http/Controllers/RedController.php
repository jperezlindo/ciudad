<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Red;

class RedController extends Controller
{
    public function index()
    {      
        $redes = Red::all();

        return $redes;
    }

    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $request->validate([
            'nombre' => 'required|max:30',
            'icono' => 'required'
        ]);
        
        $red = new Red();
        
        $red->nombre  = strtoupper($request->nombre);
        $red->icono   = $request->icono;

        $red->save();

        return $red;

    }

    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $request->validate([
            'nombre' => 'required',
            'icono' => 'required'
        ]);
       
        $red = Red::findOrFail($request->red_id);

        $red->nombre  = $request->nombre;
        $red->icono   = $request->icono;

        $red->save();

        return $red;
    }

    public function edit(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        return Red::find($request->red_id);
    }
}
