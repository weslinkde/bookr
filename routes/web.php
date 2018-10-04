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

Route::get('/', 'PagesController@home');

/*
|--------------------------------------------------------------------------
| Login/ Logout/ Password Routes
|--------------------------------------------------------------------------
*/

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
    | Dashboard Routes
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard', 'PagesController@dashboard');

    /*
    |--------------------------------------------------------------------------
    | Asset Routes
    |--------------------------------------------------------------------------
    */

    Route::get('assets/{name}', 'AssetController@showByName');
    Route::resource('assets', 'AssetController', ['except' => ['show']]);
    Route::get('assets/create', 'AssetController@create');
    Route::post('assets/post', 'AssetController@store');
    Route::post('assets/search', 'AssetController@search');
    Route::get('assets/{id}/remove/{userId}', 'AssetController@removeMember');

    Route::resource('book', 'BookingController');
    Route::get('book/Room1', 'BookingController@Room1');
    Route::get('book/Room2', 'BookingController@Room2');
    Route::get('book/Beamer', 'BookingController@Beamer');
    Route::post('bookings/store', 'BookingController@store')->name('bookingStore');
    Route::delete('bookings/delete/{id}', 'BookingController@destroy')->name('bookingDelete');

    Route::get('calendar', 'BookingController@calendar');
    Route::get('caldendar/create', 'BookingController@calendar');

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