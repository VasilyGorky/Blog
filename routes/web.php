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

Route::get('/', 'ArticlesController@index');
Route::resource('article', 'ArticlesController');
Route::resource('article', 'ArticlesController')->only(['create', 'store', 'edit', 'update', 'destroy'])->middleware('authadmin');
//Маршрут для подтверждения регистрации по e-mail
Route::get('register/confirm/{token}', 'Auth\RegisterController@confirmEmail');

Auth::routes();


