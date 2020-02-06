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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// API Routes for media library uploads and retrieval
Route::post('/media', 'API\MediaController@store')->name('api.media.store');
Route::get('/media/{mediaItem}/{size?}', 'API\MediaController@show')->name('api.media.show');