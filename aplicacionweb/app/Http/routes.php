<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index');
Route::auth();
Route::get('/admin', 'HomeController@index');
Route::get('/realizar-pedido', 'HomeController@realizarpedido');
Route::post('enviar-pedido', 'StorageController@save');
Route::get('/prueba','StorageController@prueba');
Route::get('/show','VistasController@show');
Route::get('/show','VistasController@show');
Route::post('/show/update','StorageController@update');
Route::post('/show/process','StorageController@process');
//Route::get('/profile','ProfileController@index');
