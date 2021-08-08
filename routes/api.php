<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



// Get User Data
Route::get('me', 'App\Http\Controllers\User\meController@getMe');
###########################################################################################
// Get All Users 
Route::get('Users', 'App\Http\Controllers\User\UserController@index');
// Get user by user name
Route::get('User/{username}', 'App\Http\Controllers\User\UserController@findByUsername');
// Get All Users designs
Route::get('Users/{id}/designs', 'App\Http\Controllers\Design\DesignController@getForUser');

###########################################################################################
//Get All Designs
Route::get('Designs', 'App\Http\Controllers\Design\DesignController@index');
//find Designs By Id  
Route::get('Designs/{id}', 'App\Http\Controllers\Design\DesignController@findDesign');
//find Designs by slug
Route::get('Designs/slug/{slug}', 'App\Http\Controllers\Design\DesignController@findBySlug');

###########################################################################################
//find team by slug
Route::get('teams/slug/{slug}', 'App\Http\Controllers\Teams\TeamsController@findBySlug');
//find team Designs
Route::get('teams/{id}/designs', 'App\Http\Controllers\Design\DesignController@getForTeam');

###########################################################################################
//search Design 
Route::get('search/designs', 'App\Http\Controllers\Design\DesignController@search');
//search Designer 
Route::get('search/designer', 'App\Http\Controllers\User\UserController@Search');




Route::group([
    'middleware' => 'auth',
    'prefix' => 'auth',
    'namespace' => 'App\Http\Controllers'
], function ($router) {
    Route::post('logout', 'Auth\loginController@logout')->name('logout');
    Route::put('Setting/profile', 'User\SettingController@updataProfile');
    Route::put('Setting/password', 'User\SettingController@updataPassword');



    // Route For Image Upload & Updata
    Route::post('upload', 'Design\uploadController@upload');
    Route::put('Design/{id}', 'Design\DesignController@update');
    Route::get('Design/{id}/byUser', 'Design\DesignController@userOwnsDesign');
    Route::delete('Design/{id}', 'Design\DesignController@destroy');

    // Route For make Comment 
    Route::post('Design/{id}/comments', 'Design\CommentController@store');
    Route::delete('comments/{id}', 'Design\CommentController@destroy');
    Route::put('comments/{id}', 'Design\CommentController@update');

    // like and un like 
    Route::post('Design/{id}/like', 'Design\DesignController@like');
    Route::get('Design/{id}/liked', 'Design\DesignController@checkIfUserHasLiked');

    // for teams
    Route::post('teams', 'Teams\TeamsController@store');
    Route::get('teams/{id}', 'Teams\TeamsController@findById');
    Route::get('teams', 'Teams\TeamsController@index');
    Route::get('user/teams', 'Teams\TeamsController@fetchUserTeams');
    Route::put('teams/{id}', 'Teams\TeamsController@update');
    Route::delete('teams/{id}', 'Teams\TeamsController@destroy');
    Route::delete('teams/{team_id}/users/{user_id}', 'Teams\TeamsController@removeFromTeam');


    // for Invitations

    Route::post('invitations/{teamId}', 'Teams\invitationsController@invite');
    Route::post('invitations/{id}/resend', 'Teams\invitationsController@resend');
    Route::post('invitations/{id}/respond', 'Teams\invitationsController@respond');
    Route::delete('invitations/{id}', 'Teams\invitationsController@destory');

    // for chats

    Route::post('chats', 'Chats\ChatController@sendMessage');
    Route::get('chats', 'Chats\ChatController@getUserChats');
    Route::get('chats/{id}/messages', 'Chats\ChatController@getChatMessages');
    Route::put('chats/{id}/markAsRead', 'Chats\ChatController@markAsRead');
    Route::delete('messages/{id}', 'Chats\ChatController@destroyMessage');

    // for Search


});


Route::group([

    'middleware' => 'api',
    'prefix' => 'guest',
    'namespace' => 'App\Http\Controllers'

], function ($router) {

    Route::post('Register', 'Auth\RegisterController@register')->name('Register');
    Route::post('verification/verify/{user}', 'Auth\VerificationController@verify')->name('verification.verify');
    Route::post('verification/resend', 'Auth\VerificationController@resend')->name('verification.resend');
    Route::post('login', 'Auth\LoginController@login')->name('login');
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset');
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