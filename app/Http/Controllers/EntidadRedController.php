<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\EntidadRed;
use App\Red;
use Auth;

class EntidadRedController extends Controller
{
    
    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $request->validate([
            'link' => 'required',
            'red_id' => 'required'
        ]);
       
        $entidad_red = new EntidadRed();
        
        $entidad_red->link         = $request->link;
        $entidad_red->red_id       = $request->red_id;
        $entidad_red->entidad_id   = Auth::user()->entidad_id;

        $entidad_red->save();

        return $entidad_red;

    }

    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $request->validate([
            'link' => 'required',
            'red_id' => 'required'
        ]);
       
        $entidad_red = EntidadRed::findOrFail($request->entidad_red_id);

        $entidad_red->link         = $request->link;
        $entidad_red->red_id       = $request->red_id;

        $entidad_red->save();

        return $entidad_red;
    }

    public function edit(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        return EntidadRed::find($request->entidad_red_id);
    }

    public function getEntidadRedes(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        //SI VIENE DE ADMIN LISTADO ENTIDAD_REDES NO TRAE REQUEST->ENTIDAD_ID

        if($request->entidad_id) {
            $entidad_id = $request->entidad_id;
        } else {
            $entidad_id = Auth::user()->entidad_id;
        }

        $todo = DB::table('entidad_redes')
            ->where('entidad_id', $entidad_id)
            ->join('redes', 'entidad_redes.red_id', '=', 'redes.id')
            ->select('entidad_redes.id','entidad_redes.link','redes.icono' )
            ->get();

        return $todo;
    }

    public function destroy(Request $request)
    {
        $entidad_red = EntidadRed::findOrFail($request->entidad_red_id);
        $entidad_red->delete();

        return 'Entidad red eliminada.';
    }

    
}
