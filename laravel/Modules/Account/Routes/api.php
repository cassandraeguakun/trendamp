<?php

Route::group(['prefix' => 'account'], function () {
    // Route::get('logout', 'AuthController@logoutUser');

    // Route::post('register', 'RegisterController@register');

    /*Route::get('login', 'AuthController@showLoginPage');
    Route::post('login', 'AuthController@apiLogin');*/


    Route::post('login', 'JwtApiAuthController@login');
    Route::post('logout', 'JwtApiAuthController@logout');
    Route::post('refresh', 'JwtApiAuthController@refresh');
    Route::post('me', 'JwtApiAuthController@me');

});
