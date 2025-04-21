<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use Auth;

class UserController extends Controller
{

    public function __construct()
    {
        //$this->middleware('auth', ['except' => array('getAuth', 'setPassword')]);
    }

    public function getAuth(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        
        $user = Auth::user();
        
        if ($user == null){
            return 0;
        }
        
        return 1;

    }
    
    public function index(Request $request)
    {      
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;

        if ($buscar === 'editar-mi-perfil'){
            return User::where('entidad_id', $request->entidad_id)->get();
        }
        
        if($request->all){
            return User::buscar($buscar)->get();
        }else{
            return User::buscar($buscar)->where('activo', true)->get();
        }
        
    }


    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        
        //$validated = $request->validated();
        
        $user = new User();

        $user->dni        = $request->dni;
        $user->apellido   = strtoupper($request->apellido);
        $user->nombre     = strtoupper($request->nombre);
        $user->email      = $request->email;
        $user->password   = Hash::make($request->dni);
        $user->rol_id     = 2;
        $user->entidad_id = $request->entidad_id;
        $user->save();

        return $user;

        //User::create($validated); //guarda todos los datos validados

    }


    public function edit(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        return User::find($request->user_id);
    }


    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $user = User::findOrFail($request->id);
        
        $user->dni      = $request->dni;
        $user->apellido = strtoupper($request->apellido);
        $user->nombre   = strtoupper($request->nombre);
        $user->email    = $request->email;

        $user->save();

        return $user;

    }

    public function change(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        
        $user = User::find($request->user_id);

        if ($user->activo){
            $user->activo = false;
            $res = 'Usuario Desactivado.';
        }else{
            $user->activo = true;
            $res = 'Usuario Activado.';
        }

        $user->save();

        return $res;
            
    }

    public function validarDniUsuario(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        //CREAR
        if($request->usuario_id == null){
            $user = User::where('dni',$request->dni)->first();
        //EDITAR
        } else {
            $user = User::where('id','!=',$request->usuario_id)->where('dni',$request->dni)->first();
        }

        if (!$user) {
            return 1;
        } else {
            return 0;
        }
    }

    public function validarEmailUsuario(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        //CREAR
        if($request->usuario_id == null){
            $user = User::where('email',$request->email)->first();
        //EDITAR
        } else {
            $user = User::where('id','!=',$request->usuario_id)->where('email',$request->email)->first();
        }

        if (!$user) {
            return 1;
        } else {
            return 0;
        }
    }

    public function updatePassword(Request $request){
  
        $this->validate($request,[
            'myPassword' => 'required',
            'password' => 'required|confirmed|min:6'
        ]);
  
        try {
          
          if (Hash::check($request->myPassword, Auth::user()->password)){
            
            $us = User::find($request->usuario_id);
            $us->password = bcrypt($request->password);   
            $us->save();
            
            return true;
          
        }else{
            
            return false;
          }
        } catch (\Exception $e) {
          return response()->view('errors.404', [], 404);
        }
    }
    
    public function recuperarPassword()
    {
        return view('recuperarPassword');
    }

    public function nuevaPassword(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $user = User::findOrFail($request->user_id);
        
        $user->password  = Hash::make($user->dni);

        $user->save();

        return 'Password actualizada';
        
    }
}
