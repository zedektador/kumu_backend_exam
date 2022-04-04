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

Route::post('register', 'Auth\RegisterController@create');
Route::post('login', 'Auth\LoginController@login');

Route::group(["middleware" => "api-auth:user", "prefix" => "git"], function() use ($router) {
    $router->post("usernames", "GitController@details");

});
