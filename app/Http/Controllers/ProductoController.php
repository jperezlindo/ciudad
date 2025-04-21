<?php

namespace App\Http\Controllers;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Producto;
use App\Entidad;

use Auth;
use Image;

class ProductoController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth', ['except' => array('index','show')]);
    }

    public function index(Request $request) //administrador
    {      
        if (!$request->ajax()) return redirect('/');
        
        $buscar = $request->buscar;
        $entidad_id = Auth::user()->entidad_id;

        if ($buscar){
            return Producto::buscar($buscar)->where('entidad_id', $entidad_id)->get();
        }
        
        if($request->all == 1){
            return Producto::where('entidad_id', $entidad_id)->get();
        }else{
            return Producto::where('entidad_id', $entidad_id)->where('activo', true)->get();
        }        
    }

    public function indexInvitados(Request $request) 
    {      
        if (!$request->ajax()) return redirect('/');
        
        $buscar = $request->buscar;
        $entidad_id = $request->idEntidad;
        return Producto::buscar($buscar, $entidad_id)->where('entidad_id', $entidad_id)->where('activo', true)->get();         
    }
    
    public function indexAll(Request $request) //todos los productos
    {
        if (!$request->ajax()) return redirect('/');
        
        $buscar = $request->buscar;
        
        if ($buscar){
            return Entidad::where('localidad_id', $request->idLocalidad)
            ->where('entidades.activo', "=", 1)
            ->join('productos', 'entidades.id', '=', 'productos.entidad_id')
            ->where('productos.activo', "=", 1)
            ->select('productos.*')
            ->where('productos.nombre', 'LIKE', "%$buscar%")
            ->orWhere('productos.marca', 'LIKE', "%$buscar%")
            ->orWhere('productos.descripcion', 'LIKE', "%$buscar%")
            ->get();    
        }
        
        return Entidad::where('localidad_id', $request->idLocalidad)
                        ->where('entidades.activo', "=", 1)
                        ->join('productos', 'entidades.id', '=', 'productos.entidad_id')
                        ->where('productos.activo', "=", 1)
                        ->select('productos.*')
                        ->get();
    }
    

    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $request->validate([
            'codigo' => 'required',
            'nombre' => 'required|max:100',
            'marca' => 'required|max:100'
        ]);
        
        $producto = new Producto();
        
        $producto->codigo      = $request->codigo;
        $producto->nombre      = strtoupper($request->nombre);
        $producto->marca       = strtoupper($request->marca);
        $producto->precio      = $request->precio;
        $producto->descripcion = strtoupper($request->descripcion);
        $producto->entidad_id  = Auth::user()->entidad_id;
        
        if ($request->imagen != null){
            $exploded = explode(',',$request->imagen);
            $imagen = base64_decode($exploded[1]);      

            if(Str::contains($exploded[0],'jpeg')){
                $extension = 'jpg';
            } else{
                $extension = 'png'; 
            }
           
            $fileName= Str::random(20).'.'.$extension;     
            $path = public_path('/imagenes/productos/'.$fileName);
            
            Image::make($imagen)->resize(200,250)->save($path);
            //Image::make($imagen)->widen(500)->save($path);
            
            $producto->imagen = $fileName;

        }else{
            $producto->imagen = 'producto.jpg';
        }

        $producto->save();

        return ;
    }

    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        
        $request->validate([
            'codigo' => 'required',
            'nombre' => 'required|max:100',
            'marca' => 'required|max:100'
        ]);

        $producto = Producto::findOrFail($request->producto_id);

        $producto->codigo      = $request->codigo;
        $producto->nombre      = strtoupper($request->nombre);
        $producto->marca       = strtoupper($request->marca);
        $producto->precio      = $request->precio;
        $producto->descripcion = strtoupper($request->descripcion);
        $producto->entidad_id  = Auth::user()->entidad_id;

        
        if (strcmp($producto->imagen, $request->imagen) != 0){
            $exploded = explode(',',$request->imagen);
            $imagen = base64_decode($exploded[1]);
            
            if(Str::contains($exploded[0],'jpeg')){
                $extension = 'jpg';
            } else{
                $extension = 'png'; 
            }
           
            $fileName= Str::random(20).'.'.$extension;     
            $path = public_path('/imagenes/productos/'.$fileName);
            
            Image::make($imagen)->resize(200,250)->save($path);
            //Image::make($imagen)->widen(500)->save($path);
            
            $producto->imagen = $fileName;
        }

        $producto->save();

        return $producto;
    }

    public function edit(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        return Producto::find($request->producto_id);
    }

    public function show(Request $request)  
    {
        if (!$request->ajax()) return redirect('/');

        return Producto::find($request->producto_id);
    }

    public function destroy(Request $request)
    {
        $producto = Producto::findOrFail($request->producto_id);
        $producto->delete();

        return 'Producto eliminado.';
    }

    public function change(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        
        $producto = Producto::find($request->producto_id);

        if ($producto->activo == 1){
            $producto->activo = false;
            $res = 'Producto desactivado.';
        }else{
            $activos = Producto::where('activo', true)->where('entidad_id', Auth::user()->entidad_id)->count();
            $plan = Entidad::find($producto->entidad_id)->plan_id;
            if ( $activos < $plan ){
                $producto->activo = 1;
                $res = 'Producto activado.';
            }else{
                return 1;
            }
        }

        $producto->save();
        
        return $res;
    }

    public function validarCodigoProducto(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        //CREAR
        if($request->producto_id == null){
            $producto = Producto::where('codigo',$request->codigo)->where('entidad_id',Auth::user()->entidad_id)->first();
        //EDITAR
        } else {
            $producto = Producto::where('id','!=',$request->producto_id)->where('codigo',$request->codigo)->where('entidad_id',Auth::user()->entidad_id)->first();
        }

        if (!$producto){
            return 1;
        }else{
            return 0;
        }
        
        

    }
}
