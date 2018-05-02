<?php

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "admin" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect(route('admin.home'));
});

// User routes
/*Route::get('/users', 'Admin\UserController@index')->name('users');
Route::get('/users/create', 'Admin\UserController@create')->name('users.create');
Route::post('/users', 'Admin\UserController@store')->name('users.store');
Route::get('/users/{user}', 'Admin\UserController@show')->name('users.show');
Route::get('/users/{user}/edit', 'Admin\UserController@edit')->name('users.edit');
Route::patch('/users/{user}', 'Admin\UserController@update')->name('users.update');
Route::delete('/users/{user}', 'Admin\UserController@destroy')->name('users.destroy');*/

Route::group(['as' => 'admin.', 'namespace' => 'Admin'], function () {
    Route::group(['middleware' => ['guest:admin']], function () {
        // Authentication Routes...
        Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
        Route::post('login', 'Auth\LoginController@login');

        // Password Reset Routes...
        Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
        Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
        Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
        Route::post('password/reset', 'Auth\ResetPasswordController@reset');
    });

    Route::group(['middleware' => ['auth:admin']], function () {

        Route::post('logout', 'Auth\LoginController@logout')->name('logout');

        // Account routes
        Route::get('/account', 'AccountController@index')->name('account.index');
        Route::patch('/account', 'AccountController@update')->name('account.update');
        Route::get('/account/password', 'PasswordController@index')->name('password.index');
        Route::patch('/account/password', 'PasswordController@update')->name('password.update');

        Route::get('api/session', 'ApiController@currentUser');
        Route::get('api/setting', 'ApiController@setting');

        Route::get('/home', 'HomeController@index')->name('home');

        Route::post('setting/page-size', 'SettingController@setPageSize')->name('setting.updatePageSize');
        Route::post(
            'setting/client-timezone',
            'SettingController@setClientTimezone'
        )->name('setting.updateClientTimezone');
        Route::get('setting/edit', 'SettingController@edit')->name('setting.edit');
        Route::patch('setting', 'SettingController@update')->name('setting.update');
        Route::put('banner/sortable', 'BannerController@sortable')->name('banner.sortable');
        Route::resource('banner', 'BannerController');
        Route::resource('page', 'PageController');
        Route::put('menu/sortable', 'MenuController@sortable')->name('menu.sortable');
        Route::resource('menu', 'MenuController');
        Route::resource('news', 'NewsController');
        Route::resource('user', 'UserController');
        Route::patch('member/{member}/address', 'MemberAddressController@update')->name('member.address.update');
        Route::resource('member', 'MemberController');
    });
});
