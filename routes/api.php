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
Route::post('/candidate/register', 'Auth\ApiRegisterController@register');
Route::post('/candidate/auth', ['as' => 'postLogin', 'uses' => 'Auth\ApiLoginController@login']);

Route::middleware('auth:api')->get('/profile', function () {
    return Auth::user();
});

Route::group(['middleware' => ['auth:api']], function () {
    Route::resource('users', 'Api\UserController');
    Route::resource('educations', 'Api\EducationController');
    Route::post('educations/order', 'Api\EducationController@order')->name('educations.order');
    Route::resource('experiences', 'Api\ExperienceController');
    Route::post('experiences/order', 'Api\ExperienceController@order')->name('experiences.order');
    Route::resource('recommendations', 'Api\RecommendationController');
    Route::post('uploadcv', 'Api\UploadController@CvUpload')->name('uploadcv');
    Route::post('uploadavatar', 'Api\UploadController@avatarUpload')->name('uploadavatar');
    Route::patch('candidate/profile', 'Api\CandidateProfileController@update')->name('update_c_profile');
    Route::put('candidate/profile', 'Api\CandidateProfileController@updateAll')->name('patch_update_c_profile');
});

Route::resource('countries', 'Api\CountryController', ['only' => 'index']);
Route::resource('jobs', 'Api\JobController', ['only' => 'index']);
Route::resource('departements', 'Api\DepartmentController', ['only' => 'index']);
Route::resource('skills', 'Api\SkillController', ['only' => 'index']);
Route::resource('states', 'Api\StateController', ['only' => 'index']);
Route::post('reset_password', 'Auth\SubscriberResetPassword@sendResetLinkEmail');

