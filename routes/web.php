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

use Illuminate\Support\Facades\Route;

Route::get('/', 'ArticlesController@index');
Route::resource('articles', 'ArticlesController');
Route::resource('articles', 'ArticlesController')
    ->only(['create', 'store', 'edit', 'update', 'destroy'])->middleware('authadmin');

Route::group(['prefix' => 'api'], function () {
    Route::resource('article', 'ArticlesApiController')->except(['store', 'update', 'destroy']);
    Route::group(['middleware' => 'authApiAdmin'], function () {
        Route::resource('article', 'ArticlesApiController', ['only' => ['store', 'update', 'destroy']]);
    });
});
//Маршрут для подтверждения регистрации по e-mail
Route::get('register/confirm/{token}', 'Auth\RegisterController@confirmEmail');

Auth::routes();


