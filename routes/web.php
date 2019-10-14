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

Route::get('Empleado/Editar/{id}', 'EmpleadoController@edit')->name('Empleado.Editar');

Route::put('Empleado/Editar/{id}', 'EmpleadoController@update')->name('Empleado.Actualizar');

Route::resource('/Usuario', 'UsuarioController');

Route::get('/Usuario/Editar/{id}', 'UsuarioController@edit')->name('Usuario.Editar');

Route::put('/Usuario/Editar/{id}', 'UsuarioController@update')->name('Usuario.Actualizar');

// Administración de Cajas
Route::resource('/Caja', 'CajaController');

Route::get('/Caja/index', 'CajaController@index')->name('Caja.Index');

Route::get('/Caja/management', 'CajaController@manage')->name('Caja.Administrar');

// agregar route ->name('Caja.Administrar');

Route::get('Caja/Detalles/{id}', 'CajaController@show')->name('Caja.Detalles');

Route::post('/Caja/Crear/', 'CajaController@create')->name('Caja.Crear');

Route::get('/Caja/Editar/{id}', 'CajaController@edit')->name('Caja.Editar');

Route::put('/Caja/Editar/{id}', 'CajaController@update')->name('Caja.Actualizar');

Route::delete('/Caja/Eliminar/{id}', 'CajaController@destroy')->name('Caja.Eliminar');





Route::get('/home', 'HomeController@index')->name('home');
