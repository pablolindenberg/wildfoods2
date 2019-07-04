<?php

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

Route::group(['middleware'=>['guest']],function(){
    Route::get('/','Auth\LoginController@showLoginForm');
    Route::post('/login','Auth\LoginController@login')->name('login');
});

Route::group(['middleware'=>['auth']],function(){

    Route::post('/logout', 'Auth\LoginController@logout')->name('logout');
    Route::post('/addtocart', 'CatalogoController@addToCart')->name('addtocart');

    Route::get('/main', function () {
        return view('contenido/contenido');
    })->name('main');

    Route::group(['middleware'=>['Administrador']],function(){

    Route::get('/categoria', 'CategoriaController@index');
    Route::post('/categoria/registrar', 'CategoriaController@store');
    Route::put('/categoria/actualizar', 'CategoriaController@update');
    Route::put('/categoria/desactivar', 'CategoriaController@desactivar');
    Route::put('/categoria/activar', 'CategoriaController@activar');
    Route::get('/categoria/selectCategoria', 'CategoriaController@selectCategoria');
    
    Route::get('/producto', 'ProductoController@index');
    Route::post('/producto/registrar', 'ProductoController@store');
    Route::post('/producto/cargarImagen','ProductoController@cargarImagen');
    Route::put('/producto/actualizar', 'ProductoController@update');
    Route::put('/producto/desactivar', 'ProductoController@desactivar');
    Route::put('/producto/activar', 'ProductoController@activar');
    
    Route::get('/rol', 'RolController@index');
    Route::get('/rol/selectRol', 'RolController@selectRol');
    
    Route::get('/user', 'UserController@index');
    Route::post('/user/registrar', 'UserController@store');
    //Route::post('/user/cargarImagen','UserController@cargarImagen');
    Route::put('/user/actualizar', 'UserController@update');
    Route::put('/user/desactivar', 'UserController@desactivar');
    Route::put('/user/activar', 'UserController@activar');
    
    //Route::get('/home', 'HomeController@index')->name('home');

    Route::get('/pedido', 'PedidoController@index');  
    Route::post('/pedido/registrar', 'PedidoController@store');  
    Route::put('/pedido/activarBodega', 'PedidoController@activarBodega');
    Route::put('/pedido/desactivarBodega', 'PedidoController@desactivarBodega');

    Route::put('/pedido/activar', 'PedidoController@activar');
    Route::put('/pedido/desactivar', 'PedidoController@desactivar');
});

Route::group(['middleware'=>['Cliente']],function(){
   
    Route::get('/pedido', 'PedidoController@index');

    Route::post('/pedido/registrar', 'PedidoController@store');

    Route::get('/detalle_pedido', 'Detalle_pedidoController@index');
    Route::post('/detalle_pedido/registrar', 'Detalle_pedidoController@store');

});


});



