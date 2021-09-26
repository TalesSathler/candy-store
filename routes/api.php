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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['middleware' => 'auth:api'], function () {
    Route::group(['prefix' => 'product'], function () {
        Route::get('/', '\App\Http\Controllers\ProductController@get');
        Route::get('/{product_id}', '\App\Http\Controllers\ProductController@get');
        Route::post('/', '\App\Http\Controllers\ProductController@store');
        Route::put('/{product_id}', '\App\Http\Controllers\ProductController@update');
        Route::delete('/{product_id}', '\App\Http\Controllers\ProductController@delete');
    });

    Route::group(['prefix' => 'interested'], function () {
        Route::get('/', '\App\Http\Controllers\InterestedController@get');
        Route::get('/{interested_id}', '\App\Http\Controllers\InterestedController@get');
        Route::post('/', '\App\Http\Controllers\InterestedController@store');
        Route::put('{interested_id}', '\App\Http\Controllers\InterestedController@update');
        Route::delete('{interested_id}', '\App\Http\Controllers\InterestedController@delete');
    });
});
