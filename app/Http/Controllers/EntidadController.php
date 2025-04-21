<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

use App\CategoriaEntidad;
use App\Entidad;
use App\Producto;
use App\Mensaje;

use Image;
use Auth;

class EntidadController extends Controller
{
    public function __contruct(){
        //$this->middleware('auth', ['except' => array('getEntidades')]);
    }

    public function index(Request $request)
    {      
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;

        if($request->all){
            return Entidad::with('categoriaEntidad')->buscar($buscar)->get();
        }else{
            return Entidad::with('categoriaEntidad')->buscar($buscar)->where('activo', true)->get();
        } 
    }

    public function indexInvitado(Request $request)
    {      
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $localidad_id= $request->idLocalidad;
        $ce_id = $request->idCaEn; //categoria_entidad 

        if (is_numeric($ce_id)){
            return Entidad::with('categoriaEntidad')->buscarInvitado($buscar, $ce_id)->where('localidad_id', $localidad_id)->where('activo', true)->get();
        }else{

            switch ($ce_id) {
                case "comercios":
                    $categoria = 1;
                    break;
                
                case "servicios":
                    $categoria = 2;
                    break;
                case "turismo":
                    $categoria = 3;
                    break;
                case "gastronomia":
                    $categoria = 4;
                    break;
            }

            if ($buscar){
                $bus = '%'.$buscar.'%';
                return $entidades = CategoriaEntidad::where('categoria_id', $categoria)
                                        ->join('entidades', 'categorias_entidad.id', '=', 'entidades.categoria_entidad_id')
                                        ->select('entidades.*', 'categorias_entidad.nombre AS categoria_entidad')
                                        ->where('entidades.localidad_id', '=', $localidad_id)
                                        ->where('entidades.activo', '=', 1)
                                        ->where('entidades.nombre', 'LIKE', $bus)
                                        ->orWhere('entidades.descripcion', 'LIKE', $bus)
                                        ->get();
            }else{
                return $entidades = CategoriaEntidad::where('categoria_id', $categoria)
                                        ->join('entidades', 'categorias_entidad.id', '=', 'entidades.categoria_entidad_id')
                                        ->select('entidades.*', 'categorias_entidad.nombre AS categoria_entidad')
                                        ->where('entidades.localidad_id', '=', $localidad_id)
                                        ->where('entidades.activo', '=', 1)
                                        ->get();
            }
        }
    }

    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
      
        //$validated = $request->validated();

        $entidad = new Entidad();

        $entidad->cuit        = $request->cuit;
        $entidad->nombre      = strtoupper($request->nombre);
        $entidad->direccion   = strtoupper($request->direccion);
        $entidad->coordenadas = $request->coordenadas;
        $entidad->email       = $request->email;
        $entidad->tel_cel     = $request->tel_cel;
        $entidad->plan_id     = $request->plan_id;
        $entidad->localidad_id = $request->localidad_id;
        $entidad->categoria_entidad_id = $request->categoria_entidad_id;

        if ($request->logo != null){
            $exploded = explode(',',$request->logo);
            $imagen = base64_decode($exploded[1]);
            
            if(Str::contains($exploded[0],'jpeg')){
                $extension = 'jpg';
            } else{
                $extension = 'png'; 
            }
           
            $fileName= Str::random().'.'.$extension;     
            $path = public_path('/imagenes/entidades/'.$fileName);
            Image::make($imagen)->resize(200,250)->save($path);
            $entidad->logo = $fileName;
        }else{
            $entidad->logo = 'entidad.jpg';
        }

        $entidad->save();

        return $entidad;

        //User::create($validated); //guarda todos los datos validados
    
    }

    public function edit(Request $request)
    {
        //if (!$request->ajax()) return redirect('/');

        $entidad = Entidad::find($request->entidad_id);
        $localidad = DB::table('localidades')->find($entidad->localidad_id);
        $provincia = DB::table('provincias')->find($localidad->provincia_id);
        
        $todo = new Collection();

        $todo->put('entidad', $entidad);
        $todo->put('localidad', $localidad->nombre);
        $todo->put('provincia', $provincia);
        
        
        return json_encode($todo);
    }

    public function update(Request $request){
        
        if (!$request->ajax()) return redirect('/');

        $entidad = Entidad::find($request->id);

        $entidad->cuit         = $request->cuit;
        $entidad->nombre       = strtoupper($request->nombre);
        $entidad->direccion    = strtoupper($request->direccion);
        $entidad->coordenadas  = $request->coordenadas;
        $entidad->email        = $request->email;
        $entidad->tel_cel      = $request->tel_cel;
        $entidad->descripcion  = $request->descripcion;
        $entidad->plan_id      = $request->plan_id;
        $entidad->localidad_id = $request->localidad_id;
        $entidad->categoria_entidad_id = $request->categoria_entidad_id;

        if (strcmp($entidad->logo, $request->logo) != 0){
            $exploded = explode(',',$request->logo);
            $imagen = base64_decode($exploded[1]);
            
            if(Str::contains($exploded[0],'jpeg')){
                $extension = 'jpg';
            } else{
                $extension = 'png'; 
            }
           
            $fileName= Str::random().'.'.$extension;     
            $path = public_path('/imagenes/entidades/'.$fileName);
            
            Image::make($imagen)->resize(300,400)->save($path);

            $entidad->logo = $fileName;
        }

        $entidad->save();

        return $entidad;
    }

    public function change(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        
        $entidad = Entidad::find($request->entidad_id);

        if ($entidad->activo){
            $entidad->activo = false;
        }else{
            $entidad->activo = true;
        }

        $entidad->save();    
    }

    public function validarCuitEntidad(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        //CREAR
        if($request->entidad_id == null){
            $entidad = Entidad::where('cuit',$request->cuit)->first();
        //EDITAR
        } else {
            $entidad = Entidad::where('id','!=',$request->entidad_id)->where('cuit',$request->cuit)->first();
        }

        if (!$entidad) {
            return 1;
        } else {
            return 0;
        }
    }

    public function validarEmailEntidad(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        //CREAR
        if($request->entidad_id == null){
            $entidad = Entidad::where('email',$request->email)->first();
        //EDITAR
        } else {
            $entidad = Entidad::where('id','!=',$request->entidad_id)->where('email',$request->email)->first();
        }

        if (!$entidad) {
            return 1;
        } else {
            return 0;
        }
    }

    public function getCategoriasEntidad(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        
        return DB::table('categorias_entidad')->orderBy('nombre')->get();
    }

    public function getMensajes(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $atendidos = boolval($request->atendidos);
        return DB::table('mensajes')->where('leido', $atendidos)->where('entidad_id', Auth::user()->entidad_id)->get();
    }

    public function storeMensaje(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $request->validate([
            'usuario' => 'required|max:100',
            'contacto' => 'required|max:30',
            'comentario' => 'required'
        ]);
        
        $mensaje = new Mensaje();

        $mensaje->usuario = strtoupper($request->usuario);
        $mensaje->contacto = $request->contacto;
        $mensaje->localidad = strtoupper($request->localidad);
        $mensaje->comentario = strtoupper($request->comentario);
        $mensaje->entidad_id = $request->entidad_id;
        
        $mensaje->save();
        
        return 'Gracias por elegirnos. Nos pondremos en contacto con Usted a la brevedad.';
    }

    public function changeMensaje(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $mensaje = Mensaje::find($request->mensaje_id);

        if ($mensaje->leido){
            $mensaje->leido = false;
            $res = 'Marcado como no atendido.';
        }else{
            $mensaje->leido = true;
            $res = 'Marcado como atendido.';
        }

        $mensaje->save();
        
        return $res;

    }

    public function verificarPlan(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $entidad_id = Auth::user()->entidad_id; 
        $plan = Entidad::find($entidad_id)->plan_id;
        $cantidad_productos = Producto::where('entidad_id', $entidad_id)->count();

        if ($plan > $cantidad_productos){
            return 0;
        }else{
            return 1;
        }
    }

    
    public function aplicarPlan(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        //$productosAll = Producto::where('entidad_id', $request->entidad_id)->get()

        $productos_cantidad = Producto::where('entidad_id', $request->entidad_id)->count();     
        
        if($productos_cantidad == $request->plan_id) return;

        if($productos_cantidad < $request->plan_id){
            $productos = Producto::where('entidad_id', $request->entidad_id)->where('activo', false)->get();
            foreach ($productos as $producto){
                $producto->activo = true;
                $producto->save();
            }
            return ;
        }
        
        $cantidad_activos = Producto::where('entidad_id', $request->entidad_id)->where('activo', true)->count();
        
        if ($request->plan_id == $cantidad_activos) return;

        if ($request->plan_id > $cantidad_activos){
            $diferencia = $request->plan_id - $cantidad_activos;
            $productos = Producto::where('entidad_id', $request->entidad_id)->where('activo', false)->take($diferencia)->get();
            foreach ($productos as $producto){
                $producto->activo = true;
                $producto->save();
            }
            return ;
        } else {
            $diferencia = $cantidad_activos - $request->plan_id;
            $productos = Producto::where('entidad_id', $request->entidad_id)->where('activo', true)->take($diferencia)->get();
            foreach ($productos as $producto){
                $producto->activo = false;
                $producto->save();
            }
            return ;
        }
    }

}
