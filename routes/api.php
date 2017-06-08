<?php

use Illuminate\Support\Facades\Request;
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
    Route::resource('educations', 'Api\EducationController', ['only' => 'index']);
});

Route::resource('countries', 'Api\CountryController', ['only' => 'index']);
Route::resource('jobs', 'Api\JobController', ['only' => 'index']);
Route::resource('departements', 'Api\DepartmentController', ['only' => 'index']);
Route::resource('skills', 'Api\SkillController', ['only' => 'index']);
Route::resource('states', 'Api\StateController', ['only' => 'index']);

