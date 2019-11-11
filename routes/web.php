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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// Administración de Usuarios
Route::resource('/Empleado', 'EmpleadoController');

Route::get('Empleado/Detalles/{id}', 'EmpleadoController@show')->name('Empleado.Detalles');

Route::get('/Empleado/Editar/{id}', 'EmpleadoController@edit')->name('Empleado.Editar');

Route::put('Empleado/Editar/{id}', 'EmpleadoController@update')->name('Empleado.Actualizar');

// Route::resource('/Usuario', 'UsuarioController');

// Route::get('/Usuario/Editar/{id}', 'UsuarioController@edit')->name('Usuario.Editar');

// Route::put('/Usuario/Editar/{id}', 'UsuarioController@update')->name('Usuario.Actualizar');

// // Administración de Cajas
// Route::resource('/Caja', 'CajaController');

// Route::get('/Caja/index', 'CajaController@index')->name('Caja.Index');

// Route::get('/Caja/management', 'CajaController@manage')->name('Caja.Administrar');

// // agregar route ->name('Caja.Administrar');

// Route::get('Caja/Detalles/{id}', 'CajaController@show')->name('Caja.Detalles');

// Route::post('/Caja/Crear/', 'CajaController@create')->name('Caja.Crear');

// Route::get('/Caja/Editar/{id}', 'CajaController@edit')->name('Caja.Editar');

// Route::put('/Caja/Editar/{id}', 'CajaController@update')->name('Caja.Actualizar');

// Route::delete('/Caja/Eliminar/{id}', 'CajaController@destroy')->name('Caja.Eliminar');





Route::get('/home', 'HomeController@index')->name('home');

Route::middleware(['auth'])->group(function(){
    // Roles
    Route::post('roles/store', 'RoleController@store')->name('roles.store')
        ->middleware('has.permission:roles.create');

    Route::get('roles', 'RoleController@index')->name('roles.index')
        ->middleware('has.permission:roles.index');
        
    Route::get('roles/create', 'RoleController@create')->name('roles.create')
        ->middleware('has.permission:roles.create');

    Route::put('roles/{role}', 'RoleController@update')->name('roles.update')
        ->middleware('has.permission:roles.edit');

    Route::get('roles/{role}', 'RoleController@show')->name('roles.show')
        ->middleware('has.permission:roles.show');

    Route::delete('roles/{role}', 'RoleController@destroy')->name('roles.destroy')
        ->middleware('has.permission:roles.destroy');

    Route::get('roles/{role}/edit', 'RoleController@edit')->name('roles.edit')
        ->middleware('has.permission:roles.edit');
    
    // Ventas
    Route::resource('/ventas', 'SalesController');

    Route::post('ventas/buscar', 'SalesController@buscar')->name('ventas.buscar')
        ->middleware('has.permission:ventas.index');

    Route::get('ventas/create', 'SalesController@create')->name('ventas.create')
        ->middleware('has.permission:ventas.create');
    
    Route::post('ventas/store', 'SalesController@store')->name('ventas.store')
        ->middleware('has.permission:ventas.create');
        
    Route::post('ventas/storeDetail', 'SalesController@storeDetail')->name('ventas.storeDetail')
        ->middleware('has.permission:ventas.create');

    Route::get('ventas/showDetails/{facturaId}', 'SalesController@showDetails')->name('ventas.showDetails')
        ->middleware('has.permission:ventas.create');
    
    Route::put('ventas/update/{id}', 'SalesController@update')->name('ventas.update')
        ->middleware('has.permission:ventas.update');
        
    Route::put('ventas/{id}/updateState', 'SalesController@updateState')->name('ventas.updateState')
        ->middleware('has.permission:ventas.updateState');

    Route::put('ventas/updateDetail/{id}', 'SalesController@updateDetail')->name('ventas.updateDetail')
        ->middleware('has.permission:ventas.update');

    Route::put('ventas/destroy/{id}', 'SalesController@destroy')->name('ventas.destroy')
        ->middleware('has.permission:ventas.destroy');

    Route::put('ventas/cobrar/{id}', 'SalesController@cobrar')->name('ventas.update')
        ->middleware('has.permission:ventas.update');

    // Búsqueda de menu
    Route::post('ventas/getMenu', 'SalesController@getMenu')->name('ventas.getMenu')
        ->middleware('has.permission:ventas.create');
        
    Route::post('ventas/getEmpleados', 'SalesController@getEmpleados')->name('ventas.getEmpleados')
        ->middleware('has.permission:ventas.create');

    Route::post('ventas/getMesas', 'SalesController@getMesas')->name('ventas.getMesas')
        ->middleware('has.permission:ventas.create');
    

    // Facturas subsystem
    

    // Cajas subsystem
    Route::post('cajas/store', 'CajaController@store')->name('cajas.store')
        ->middleware('has.permission:cajas.create');

    Route::get('cajas', 'CajaController@index')->name('cajas.index')
        ->middleware('has.permission:cajas.index');
        
    Route::get('cajas/create', 'CajaController@create')->name('cajas.create')
        ->middleware('has.permission:cajas.create');

    Route::put('cajas/{id}', 'CajaController@update')->name('cajas.update')
        ->middleware('has.permission:cajas.edit');

    Route::get('cajas/{id}', 'CajaController@show')->name('cajas.show')
        ->middleware('has.permission:cajas.show');

    Route::delete('cajas/{id}', 'CajaController@destroy')->name('cajas.destroy')
        ->middleware('has.permission:cajas.destroy');

    Route::get('cajas/{id}/edit', 'CajaController@edit')->name('cajas.edit')
        ->middleware('has.permission:cajas.edit');

    // Gastos
    Route::get('gastos', 'GastoController@index')->name('gastos.index')
        ->middleware('has.permission:gastos.index');

    Route::post('gastos/create', 'GastoController@store')->name('gastos.create')
        ->middleware('has.permission:gastos.create');

    Route::delete('gastos/{id}', 'GastoController@destroy')->name('gastos.destroy')
        ->middleware('has.permission:gastos.destroy');

    // Users
    Route::get('users', 'UserController@index')->name('users.index')
        ->middleware('has.permission:users.index');
        
    Route::put('users/{id}', 'UserController@update')->name('users.update')
        ->middleware('has.permission:users.edit');

    Route::get('users/{id}', 'UserController@show')->name('users.show')
        ->middleware('has.permission:users.show');

    Route::delete('users/{id}', 'UserController@destroy')->name('users.destroy')
        ->middleware('has.permission:users.destroy');

    Route::get('users/{id}/edit', 'UserController@edit')->name('users.edit');
        // ->middleware('has.permission:users.edit');
});