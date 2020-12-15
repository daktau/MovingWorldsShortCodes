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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('shortcodes', 'ApiController@getAllShortcodesForUser');
Route::get('shortcodes/{id}', 'ApiController@getShortcode');
Route::post('shortcodes', 'ApiController@createShortcode');
Route::put('shortcodes/{id}', 'ApiController@updateShortcode');
Route::delete('shortcodes/{id}','ApiController@deleteShortcode');
