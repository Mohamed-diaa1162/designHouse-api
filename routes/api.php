<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('me' , 'App\Http\Controllers\User\meController@getMe');

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth' ,
    'namespace' => 'App\Http\Controllers'
], function ($router) {
    Route::post('logout', 'Auth\loginController@logout')->name('logout');
    Route::put('Setting/profile' , 'User\SettingController@updataProfile' );
    Route::put('Setting/password' , 'User\SettingController@updataPassword' );

});


Route::group([

    'middleware' => 'api',
    'prefix' => 'guest' ,
    'namespace' => 'App\Http\Controllers\Auth'

], function ($router) {

    Route::post('Register', 'RegisterController@register')->name('Register');
    Route::post('verification/verify/{user}', 'VerificationController@verify')->name('verification.verify');
    Route::post('verification/resend', 'VerificationController@resend')->name('verification.resend');
    Route::post('login', 'LoginController@login')->name('login');
    Route::post('password/email' , 'ForgotPasswordController@sendResetLinkEmail');
    Route::post('password/reset' , 'ResetPasswordController@reset');


});

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });