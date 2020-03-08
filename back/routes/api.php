<?php

use Illuminate\Http\Request;
use Illuminate\Routing\RouteGroup;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'auth'], function () {
    Route::post('register', 'API\AuthController@register');
    Route::post('login', 'API\AuthController@login');
    Route::get('signup/activate/{token}', 'API\AuthController@registerActivate');
    Route::group(['middleware' => 'auth:api'], function () {
        Route::get('logout', 'API\AuthController@logout');
        Route::get('user', 'API\AuthController@user');
    });
});

Route::group(['prefix' => 'empleado'], function () {
    Route::group(['middleware' => ['auth:api']], function () {
        Route::post('', 'API\EmpleadoController@store');
        Route::get('showPorUsuario/{idUser}', 'API\EmpleadoController@showPorUsuario');
        Route::get('', 'API\EmpleadoController@index');
        Route::put('', 'API\EmpleadoController@update');
        Route::get('/{id}','API\EmpleadoController@show');
    });
});
