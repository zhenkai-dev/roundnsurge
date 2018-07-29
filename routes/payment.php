<?php
/**
 * Created by PhpStorm.
 * User: Kit Loong
 * Date: 22/7/2018
 * Time: 5:45 PM
 */

Route::get('paypal/create-submit', 'Payment\PaypalController@createFormAndSubmit')->name('paypal.createSubmit');
Route::get('paypal/response', 'Payment\PaypalController@response')->name('paypal.response');
Route::get('paypal/ipn', 'Payment\PaypalController@ipn')->name('paypal.ipn');