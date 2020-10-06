<?php

Route::prefix('admin')->namespace('App\Http\Controllers\Auth\Admin')->name('admin.auth.')->group(function () {
    Route::get('login', 'LoginController@login')->name('login');
    Route::post('login', 'LoginController@loginAdmin')->name('loginAdmin');
    Route::post('logout', 'LoginController@logout')->name('logout');
});

Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin.')->middleware('auth:admin')->group(function () {

//  ==================================== Category ====================================
    Route::get('/category/create', 'CategoryController@create');
    Route::post('/category/store', 'CategoryController@store');
    Route::get('/category/fetch', 'CategoryController@fetch');
    Route::get('/category/fetch/test', 'CategoryController@fetchTest');
    Route::get('/category/fetchall', 'CategoryController@fetchall');
    Route::get('/category/fetchsubcat/{id}', 'CategoryController@fetchsubcat');
    Route::get('/category/fetchsubsubcat/{id}', 'CategoryController@fetchsubsubcat');
    Route::get('/category/fetchsubs/{id}', 'CategoryController@fetchsubs');
    Route::get('/category', 'CategoryController@index');
    Route::get('/category/delete/{id}', 'CategoryController@delete');
    Route::get('/category/search', 'CategoryController@search');
    Route::get('/category/showedit/{id}', 'CategoryController@showedit');
    Route::get('/category/fetnewcat/{id}', 'CategoryController@fetnewcat');
    Route::post('/category/update', 'CategoryController@update');
    Route::get('/category/fetch/cat/root/{type}', 'CategoryController@fetchRootCat');
    Route::get('/category/fetch/cat/child/{id}/{type}', 'CategoryController@fetchRootChild');
    Route::get('/category/fetch/brand', 'CategoryController@fetchBrands');
    Route::post('/category/edit', 'CategoryController@edit');
    Route::get('/category/search/brand/{brand}', 'CategoryController@searchBrand');
    Route::get('/category/fetch/search/cats', 'CategoryController@fetchSearchCat');


});