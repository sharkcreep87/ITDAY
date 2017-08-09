<?php

use Illuminate\Http\Request;

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

Route::group(['middleware'=>'api'], function(){
	Route::get('user', 'Core\AuthController@index');
	Route::get('user/{id}', 'Core\AuthController@getProfile');
	Route::post('user', 'Core\AuthController@register');
	Route::post('activation', 'Core\AuthController@activate');
	Route::post('remember', 'Core\AuthController@postRemember');
	Route::post('login', 'Core\AuthController@signin');
	Route::post('user/{id}', 'Core\AuthController@postProfile');
	Route::post('password/{id}', 'Core\AuthController@postProfile');
	Route::post('avatar/{id}', 'Core\AuthController@postProfile');
	{apiroutes}
});