<?php
/**
 * Created by PhpStorm.
 * User: Kit Loong
 * Date: 22/7/2018
 * Time: 5:45 PM
 */

Route::get('paypal/create-submit', 'Payment\PaypalController@createFormAndSubmit')->name('paypal.createSubmit');

Route::get('paypal/ipn', 'Payment\PaypalController@ipn')->name('paypal.ipn');

Route::group(['middleware' => ['web.viewComposer']], function () {
    Route::get('paypal/response/{orderNo}', 'Payment\PaypalController@response')->name('paypal.response');
});