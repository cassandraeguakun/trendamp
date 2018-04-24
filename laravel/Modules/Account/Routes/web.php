<?php

Route::group(['prefix' => 'account'], function () {

    Route::get('logout', 'AuthController@logoutUser');
    Route::post('register', 'RegisterController@register');

    Route::post('login', 'AuthController@webLogin');
    Route::get('login', 'AuthController@showLoginPage');


});
