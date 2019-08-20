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

/*
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
*/



Route::resource('clients', 'Api\ClientController',['only' => ['index','show']]);

Route::resource('contracts', 'Api\ContractController',['only' => ['index','show']]);

Route::resource('users', 'Api\UserController',['except' => ['create','edit']]);
