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

Route::get('/detalles/{id}', 'EmpleadoController@show')->name('Empleado.Detalles');

Route::get('/editar/{id}', 'EmpleadoController@edit')->name('Empleado.Editar');

Route::put('/editar/{id}', 'EmpleadoController@update')->name('Empleado.Actualizar');

Route::resource('/Usuario', 'UsuarioController');

Route::get('/usuario/editar/{id}', 'UsuarioController@edit')->name('Usuario.Editar');

Route::put('/usuario/editar/{id}', 'UsuarioController@update')->name('Usuario.Actualizar');

// Administración de Cajas
Route::resource('Caja', 'CajaController');

Route::get('/Caja', 'CajaController@index')->name('Caja.Administracion');








Route::get('/home', 'HomeController@index')->name('home');
