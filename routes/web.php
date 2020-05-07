<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where [you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => 'localization', 'prefix' => Session::get('locale')], function () {
    Route::get('/', function () {
        return view('profile');
    });

    Route::get('login', 'Auth\LoginController@form')->name('login-form');
    Route::post('login', 'Auth\LoginController@login')->name('login');
    Route::get('logout', 'Auth\LoginController@logout')->name('logout');
    Route::post('lang', 'LangController@setLang')->name('lang');

    Route::group(['prefix' => 'me', 'middleware' => ['login', 'XSS']], function () {
        Route::get('/', 'AdminController@show')->name('admin.show');
        Route::post('/', 'AdminController@update')->name('admin.update');
        Route::get('password', 'Auth\ChangePasswordController@show')->name('admin.changepass.show');
        Route::post('password', 'Auth\ChangePasswordController@update')->name('admin.changepass.update');
    });

    Route::group(['prefix' => 'users', 'middleware' => ['adminLogin', 'XSS']], function () {
        Route::get('lists', 'UserController@index')->name('user.index');
        Route::get('search', 'UserController@search')->name('user.search');
        Route::delete('{id}/delete', 'UserController@destroy')->name('user.destroy');
        Route::get('{id}/edit', 'UserController@show')->name('user.show');
        Route::post('{id}/edit', 'UserController@update')->name('user.update');
        Route::get('add', 'UserController@create')->name('user.create');
        Route::post('add', 'userController@store')->name('user.store');
        Route::get('{id}/password', 'UserController@changePassword')->name('user.changepass.show');
        Route::post('{id}/password', 'UserController@updatePassword')->name('user.changepass.update');
        Route::get('{id}/role', 'UserController@changeRole')->name('user.changerole.show');
        Route::post('{id}/role', 'UserController@updateRole')->name('user.changerole.update');
    });

    Route::group(['prefix' => 'devices', 'middleware' => ['login', 'XSS']], function () {
        Route::get('me', 'DeviceController@myDevices')->name('me.device.index');
    });

    Route::group(['prefix' => 'devices', 'middleware' => ['adminLogin', 'XSS']], function () {
        Route::get('lists', 'DeviceController@index')->name('device.index');
        Route::get('search', 'DeviceController@search')->name('device.search');
        Route::delete('{id}/delete', 'DeviceController@destroy')->name('device.destroy');
        Route::get('{id}/edit', 'DeviceController@show')->name('device.show');
        Route::post('{id}/edit', 'DeviceController@update')->name('device.update');
        Route::get('add', 'DeviceController@create')->name('device.create');
        Route::post('add', 'DeviceController@store')->name('device.store');
        Route::get('lists/users', 'DeviceController@devicesOfUsers')->name('device.user.index');

        Route::get('{id}/getUser', 'DeviceController@getUserOfDevice')->name('device.user');
        Route::get('{id}/getReason', 'DeviceController@getReasonOfDevice')->name('device.reason');
        Route::get('{id}/getHistory', 'DeviceController@getHistoryOfDevice')->name('device.history');
        Route::post('{device_id}/{user_id}/release', 'DeviceController@release')->name('device.release');
        Route::post('{device_id}/{user_id}/assign', 'DeviceUserController@assign')->name('device.assign');
    });

    Route::group(['prefix' => 'requests', 'middleware' => ['login', 'XSS']], function () {
        Route::get('me', 'RequestController@myRequests')->name('request.me.index');
        Route::get('lists', 'RequestController@index')->name('request.index');
        Route::get('search', 'RequestController@search')->name('request.search');
        Route::delete('{id}/delete', 'RequestController@destroy')->name('request.destroy');
        Route::post('{id}/approve', 'RequestController@approveRequest')->name('request.approve');
        Route::get('add', 'RequestController@create')->name('request.create');
        Route::post('add', 'RequestController@store')->name('request.store');
        Route::get('{id}/edit', 'RequestController@show')->name('request.show');
        Route::post('{id}/edit', 'RequestController@update')->name('request.update');
    });
});
