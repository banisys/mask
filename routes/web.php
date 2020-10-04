<?php

use Illuminate\Support\Facades\Auth;

Route::namespace('App\Http\Controllers\Auth')->group(function () {
    Route::get('/login', 'LoginController@login')->name('login');
    Route::post('/validation/register', 'RegisterController@registerValidation');
    Route::post('/validation/login', 'LoginController@loginValidation');
    Route::post('/register/store', 'RegisterController@registerStore');
    Route::post('/login/store', 'LoginController@loginStore');
    Route::get('/register', 'RegisterController@register');
    Route::post('/login/send/code', 'LoginController@sendCode');
    Route::post('/login/check/code', 'LoginController@checkCode');
});

Route::get('/logout', function () {
    Auth::logout();
});





