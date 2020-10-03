<?php

Route::namespace('App\Http\Controllers\Auth')->group(function () {
    Route::get('/login', 'LoginController@login')->name('login');
    Route::post('/validation/register', 'RegisterController@registerValidation');
    Route::post('/validation/login', 'LoginController@loginValidation');
    Route::post('/register/store', 'RegisterController@registerStore');
    Route::post('/login/store', 'LoginController@loginStore');
    Route::get('/register', 'RegisterController@register');
    Route::get('/register', 'RegisterController@register');
});





