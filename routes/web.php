<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', 'HomeController@index')->name('index');

Auth::routes();

//PAGOS
Route::get('/listado-pagos', 'PagoController@index');
Route::post('/pago', 'PagoController@store');

//HOME
Route::get('/terminos-y-condiciones-de-uso-y-privacidad', 'HomeController@terminos')->name('terminos');
Route::get('/costos-de-nuestros-planes', 'HomeController@planes')->name('planes');
Route::get('/listar-provincias', 'HomeController@getProvincias');
Route::get('/listar-localidades', 'HomeController@getLocalidades');

Route::get('/localidades', 'HomeController@localidades');

Route::get('/listado-comercios', 'HomeController@getComercios');
Route::get('/listado-servicios', 'HomeController@getServicios');
Route::get('/listado-turismo', 'HomeController@getturismo');
Route::get('/listado-resto', 'HomeController@getResto');

//ANUNCIATE
Route::post('/crear-mensaje', 'EntidadController@storeMensaje');
Route::get('/listado-mensajes', 'EntidadController@getMensajes');
Route::put('/cambiar-estado-mensaje', 'EntidadController@changeMensaje');

//USUARIOS
Route::get('/get-auth-user', 'UserController@getAuth');
Route::get('/listado-usuarios', 'UserController@index');
Route::get('/editar-usuario', 'UserController@edit');
Route::post('/crear-usuario', 'UserController@store');
Route::put('/actualizar-usuario', 'UserController@update');
Route::put('/cambiar-estado-usuario', 'UserController@change');
Route::put('/update-password', 'UserController@updatePassword');

//RECUPERAR CONTRASEÑA
Route::get('/recuperar-password', 'UserController@recuperarPassword');
Route::put('/nueva-password', 'UserController@nuevaPassword');

//ENTIDADES
Route::get('/listado-entidades', 'EntidadController@index');
Route::get('/listado-entidades-disponibles', 'EntidadController@indexInvitado');
Route::post('/crear-entidad', 'EntidadController@store');
Route::get('/editar-entidad', 'EntidadController@edit');
Route::put('/actualizar-entidad', 'EntidadController@update');
Route::put('/cambiar-estado-entidad', 'EntidadController@change');
Route::get('/categorias-entidad', 'EntidadController@getCategoriasEntidad');
Route::put('/aplicar-plan-activo', 'EntidadController@aplicarPlan');
Route::get('/verificar-plan', 'EntidadController@verificarPlan');

//CATEGORIAS_ENTIDAD
Route::get('/listado-categorias-entidad', 'CategoriaEntidadController@index');
Route::post('/crear-categoria-entidad', 'CategoriaEntidadController@store');
Route::get('/editar-categoria-entidad', 'CategoriaEntidadController@edit');
Route::put('/actualizar-categoria-entidad', 'CategoriaEntidadController@update');

//PRODUCTOS
Route::get('/listado-productos', 'ProductoController@index');
Route::get('/invitado-listado-productos', 'ProductoController@indexInvitados');
Route::get('/invitado-listado-productos-disponibles', 'ProductoController@indexAll');
Route::post('/crear-producto', 'ProductoController@store');
Route::get('/editar-producto', 'ProductoController@edit');
Route::put('/actualizar-producto', 'ProductoController@update');
Route::put('/cambiar-estado-producto', 'ProductoController@change');
Route::get('/ver-producto', 'ProductoController@show');
Route::delete('/eliminar-producto', 'ProductoController@destroy');


//VALIDACIONES
Route::get('/validar-dni-usuario', 'UserController@validarDniUsuario');
Route::get('/validar-email-usuario', 'UserController@validarEmailUsuario');

Route::get('/validar-cuit-entidad', 'EntidadController@validarCuitEntidad');
Route::get('/validar-email-entidad', 'EntidadController@validarEmailEntidad');

Route::get('/validar-codigo-producto', 'ProductoController@validarCodigoProducto');

//REDES
Route::get('/listado-redes', 'RedController@index');
Route::post('/crear-red', 'RedController@store');
Route::get('/editar-red', 'RedController@edit');
Route::put('/actualizar-red', 'RedController@update');

//ENTIDAD_REDES
Route::post('/crear-entidad-red', 'EntidadRedController@store');
Route::get('/editar-entidad-red', 'EntidadRedController@edit');
Route::get('/listado-entidad-redes', 'EntidadRedController@getEntidadRedes');
Route::put('/actualizar-entidad-red', 'EntidadRedController@update');
Route::delete('/eliminar-entidad-red', 'EntidadRedController@destroy');


