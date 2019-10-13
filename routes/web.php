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

Route::get('empleado/detalles/{id}', 'EmpleadoController@show')->name('Empleado.Detalles');

Route::get('empleado/editar/{id}', 'EmpleadoController@edit')->name('Empleado.Editar');

Route::put('empleado/editar/{id}', 'EmpleadoController@update')->name('Empleado.Actualizar');

Route::resource('/Usuario', 'UsuarioController');

Route::get('/usuario/editar/{id}', 'UsuarioController@edit')->name('Usuario.Editar');

Route::put('/usuario/editar/{id}', 'UsuarioController@update')->name('Usuario.Actualizar');

// Administración de Cajas
Route::resource('Caja', 'CajaController');

Route::get('/Caja/index', 'CajaController@index')->name('Caja.Administrar');

Route::get('caja/detalles/{id}', 'CajaController@show')->name('Caja.Detalles');

Route::post('/caja/crear/', 'CajaController@create')->name('Caja.Crear');

Route::get('/caja/editar/{id}', 'CajaController@edit')->name('Caja.Editar');

Route::put('/caja/editar/{id}', 'CajaController@update')->name('Caja.Actualizar');

Route::delete('/caja/eliminar/{id}', 'CajaController@destroy')->name('Caja.Eliminar');





Route::get('/home', 'HomeController@index')->name('home');
