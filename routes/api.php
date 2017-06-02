<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use \Illuminate\Support\Facades\Route;

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

Route::post('/register', 'Auth\RegisterController@register');
Route::get('/confirm/{id}/{token}', 'Auth\ApiLoginController@confirm');
Route::post('/oauth/token', [
    'uses' => 'Api\CustomAccessTokenController@issueUserToken'
]);
Route::post('/login', 'Auth\ApiLoginController@login');

Route::middleware('auth:api')->get('/profile', function () {
    return Auth::user();
});

Route::group(['middleware' => ['auth:api', 'autrhorization']], function () {
    Route::resource('users', 'Api\UserController');
    Route::resource('cars', 'Api\CarController');
});
