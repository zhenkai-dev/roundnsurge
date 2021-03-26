<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['as' => 'web.', 'namespace' => 'Web', 'middleware' => ['web.viewComposer']], function () {
    Route::group(['middleware' => ['guest:web']], function () {
        Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
        Route::post('login', 'Auth\LoginController@login');

        // Password Reset Routes...
        Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
        Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
        Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
        Route::post('password/reset', 'Auth\ResetPasswordController@reset');

        // Registration Routes...
        Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
        Route::post('register', 'Auth\RegisterController@register');
    });

    Route::group(['middleware' => ['auth:web']], function () {
        Route::get('register/referral', 'Auth\RegisterController@referral')->name('register.referral');
        Route::post('logout', 'Auth\LoginController@logout')->name('logout');

        // Account routes
        Route::get('/account', 'AccountController@index')->name('account.index');
        Route::patch('/account', 'AccountController@update')->name('account.update');
        Route::get('/account/password', 'PasswordController@index')->name('password.index');
        Route::patch('/account/password', 'PasswordController@update')->name('password.update');
        Route::get('/account/address', 'Account\AddressController@index')->name('account.address');
        Route::patch('/account/address', 'Account\AddressController@update')->name('account.address.update');
    });

    Route::get('/', 'HomeController@index')->name('home');

    Route::get('news', 'NewsController@index')->name('news.index');
    Route::get('news/{slug}', 'NewsController@show')->name('news.show');
    Route::get('events', 'EventController@index')->name('events.index');
    Route::get('pages/{slug}', 'PageController@show')->name('pages.show');

    Route::post('contact/submit', 'EnquiryController@submit')->name('enquiry.submit');
});
