<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a given Closure or controller and enjoy the fresh air.
|
*/

/*
|--------------------------------------------------------------------------
| Welcome Route
|--------------------------------------------------------------------------
*/

Route::get('/', 'Auth\LoginController@showLoginForm');

/*
|--------------------------------------------------------------------------
| Login/ Logout/ Password Routes
|--------------------------------------------------------------------------
*/

Route::get('/redirect', 'SocialAuthGoogleController@redirect');
Route::get('/callback', 'SocialAuthGoogleController@callback');


Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');

Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');

/*
|--------------------------------------------------------------------------
| Registration & Activation Routes
|--------------------------------------------------------------------------
*/

Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');

Route::get('activate/token/{token}', 'Auth\ActivateController@activate');
Route::group(['middleware' => ['auth']], function () {
    Route::get('activate', 'Auth\ActivateController@showActivate');
    Route::get('activate/send-token', 'Auth\ActivateController@sendToken');
});

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/


Route::group(['middleware' => ['auth']], function () {

    /*
    |--------------------------------------------------------------------------
    | General Routes
    |--------------------------------------------------------------------------
    */

    Route::get('/users/switch-back', 'Admin\UserController@switchUserBack');

    /*
    |--------------------------------------------------------------------------
    | User Routes
    |--------------------------------------------------------------------------
    */

    Route::group(['prefix' => 'user', 'namespace' => 'User'], function () {
        Route::get('settings', 'SettingsController@settings');
        Route::post('settings', 'SettingsController@update');
        Route::get('password', 'PasswordController@password');
        Route::post('password', 'PasswordController@update');
    });

    /*
    |--------------------------------------------------------------------------
    | Asset Routes
    |--------------------------------------------------------------------------
    */

    Route::get('calendar/create',                                   'CalendarController@create');
    Route::post('calendar/store',                                   'CalendarController@store');
    Route::get('calendar/{calendar_id}/edit',                    'CalendarController@edit');
    Route::patch('calendar/{calendar_id}/update',                   'CalendarController@update');
    Route::delete('calendar/{calendar_id}/delete',                  'CalendarController@destroy');

    Route::get('book',                                              'AssetsController@index');
    Route::get('calendar/{calendar_id}/asset/create',               'AssetsController@create');
    Route::post('calendar/{calendar_id}/asset/store',               'AssetsController@store')->name('storeAsset');
    Route::get('calendar/{calendar_id}/asset/edit',                 'AssetsController@chooseEdit');
    Route::get('calendar/{calendar_id}/asset/{asset_id}/edit',      'AssetsController@edit');
    Route::patch('calendar/{calendar_id}/asset/{asset_id}/update',  'AssetsController@update')->name('updateAsset');
    Route::delete('calendar/{calendar_id}/asset/{asset_id}/delete', 'AssetsController@destroy')->name('deleteAsset');


    //Route::get('book', 'BookingController@index');
    Route::get('book/{assetId}',[
        'uses' => 'BookingController@calendar',
        'as'   => 'assetId'
    ]);
    Route::get('book/edit/{id}', 'BookingController@editInfo');
    Route::post('book/{assetId}/store',[
        'uses' => 'BookingController@store',
        'as'   => 'assetId'
    ])->name('storeBeamer');
    Route::patch('book/{assetId}/edit/{id}',[
        'uses' => 'BookingController@update',
        'as'   => 'assetId'
    ])->name('editBeamer');
    Route::delete('book/{assetId}/delete/{id}',[
        'uses' => 'BookingController@destroy',
        'as'   => 'assetId'
    ])->name('deleteBeamer');
    Route::delete('book/{assetId}/delete',[
        'uses' => 'BookingController@destroyAll',
        'as'   => 'assetId'
    ])->name('deleteAll');


    Route::get('team/{name}', 'TeamController@showByName');
    Route::get('teams/{id}/show', 'TeamController@show');
    Route::resource('teams', 'TeamController', ['except' => ['show']]);
    Route::post('teams/search', 'TeamController@search');
    Route::get('team/{id}/invite', 'TeamController@invite');
    Route::post('team/{id}/invite/send', 'TeamController@inviteMember');
    Route::get('teams/{id}/remove/{userId}', 'TeamController@removeMember');

    Route::get('team/{id}/accept/{token}', 'Teamcontroller@accept')->name('accept');


    /*
    |--------------------------------------------------------------------------
    | Admin Routes
    |--------------------------------------------------------------------------
    */

    Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => 'admin'], function () {

        Route::get('dashboard', 'DashboardController@index');

        /*
        |--------------------------------------------------------------------------
        | User Routes
        |--------------------------------------------------------------------------
        */

        Route::resource('users', 'UserController', ['except' => ['create', 'show']]);
        Route::post('users/search', 'UserController@search');
        Route::get('users/search', 'UserController@index');
        Route::get('users/invite', 'UserController@getInvite');
        Route::get('users/switch/{id}', 'UserController@switchToUser');
        Route::post('users/invite', 'UserController@postInvite');

        /*
        |--------------------------------------------------------------------------
        | Role Routes
        |--------------------------------------------------------------------------
        */

        Route::resource('roles', 'RoleController', ['except' => ['show']]);
        Route::post('roles/search', 'RoleController@search');
        Route::get('roles/search', 'RoleController@index');
    });

});

/*
|--------------------------------------------------------------------------
| Todo Routes
|--------------------------------------------------------------------------
*/

Route::resource('todos', 'TodosController', ['except' => ['show']]);
Route::post('todos/search', [
    'as' => 'todos.search',
    'uses' => 'TodosController@search'
]);