<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth',
    'namespace'=> 'App\Http\Controllers'

], function ($router) {

    
    Route::post('login', 'AuthController@login')->name('login');

    Route::middleware('auth:api')->group(function(){

        Route::get('logout', 'AuthController@logout');
        Route::post('refresh', 'AuthController@refresh');
        Route::get('me', 'AuthController@me');

    });
});

Route::apiResource('products','App\Http\Controllers\ProductController')->except('show')->middleware(['api','auth:api']);
    