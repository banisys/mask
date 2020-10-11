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
    Route::get('/category/fetch/cat/root', 'CategoryController@fetchRootCat2');
    Route::get('/category/fetch/cat/child/select/{id}', 'CategoryController@fetchRootChildSelect');

//  ==================================== Brand ====================================
    Route::get('/brand/create', 'BrandController@create');
    Route::post('/brand/store', 'BrandController@store');
    Route::get('/brand/fetch', 'BrandController@fetch');
    Route::get('/brand/fetch/all', 'BrandController@fetchAll');
    Route::get('/brand/fetch/{cat}', 'BrandController@fetchBrandCat');
    Route::get('/brand/search', 'BrandController@search');
    Route::get('/brand/image/{id}', 'BrandController@image');
    Route::get('/brand/description/{id}', 'BrandController@description');
    Route::get('/brand/delete/{id}', 'BrandController@delete');
    Route::post('/brand/edit/cat', 'BrandController@editCat');
    Route::get('/brand/fetch/cat/child/{id}', 'BrandController@fetchRootChild');
    Route::get('/brand/fetch/cat/root', 'BrandController@fetchRootCat');
    Route::get('/brand/cat', 'BrandController@fechCat');

//  ==================================== Product ====================================
    Route::get('/product/create', 'ProductController@create');
    Route::get('/product/index', 'ProductController@index');
    Route::get('/product/edit/{id}', 'ProductController@edit');
    Route::get('/product/effect/price/{id}', 'ProductController@fetchEffectPriceId');
    Route::get('/product/{id}', 'ProductController@fetchProduct');
    Route::get('/product/catspec/{id}', 'ProductController@fechCatspec');
    Route::post('/product/store', 'ProductController@store');
    Route::post('/product/update/{id}', 'ProductController@update');
    Route::get('/product/aaa/fetch', 'ProductController@fetch');
    Route::get('/product/fetch/value/{pro}', 'ProductController@fetchValue');
    Route::get('/product/fetch/effect/values/{id}', 'ProductController@fetchEffectVal');
    Route::get('/product/fetch/colors/{pro}', 'ProductController@fetchColors');
    Route::get('/product/fetch/gallery/{pro}', 'ProductController@fetchGallery');
    Route::get('/product/delete/gallery/{id}', 'ProductController@deleteGallery');
    Route::get('/product/delete/color/image/{id}', 'ProductController@deleteColorImage');
    Route::get('/product/delete/{id}', 'ProductController@delete');
    Route::get('/product/a/search', 'ProductController@search');
    Route::get('/product/fetch/count', 'ProductController@proCount');
    Route::get('/product/effect/price/{cat}/{brand}', 'ProductController@fetchEffectPrice');
    Route::get('/product/color/image/{id}', 'ProductController@colorImageShow');
    Route::get('/product/fetch/cat/id/{name}', 'ProductController@getCatId');
    Route::get('/product/fetch/brands/{product_id}', 'ProductController@fetchBrands');
    Route::post('/product/edit/price', 'ProductController@editPrice');

});