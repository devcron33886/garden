<?php

use Illuminate\Support\Facades\Route;


Route::namespace('API')->group(function () {
    Route::post('login', 'UsersController@login');
    Route::post('register', 'UsersController@register');

    Route::group(['middleware' => 'auth:api'], function () {
        Route::post('details', 'UsersController@details');
    });

    Route::get('/home/products/random', 'HomeController@randomProducts');
    Route::get('/top/products', 'HomeController@topSoldProducts');
    Route::get('/home/products/new', 'HomeController@newProducts');
    Route::get('/categories', 'CategoriesController@index');
    Route::get('/products/category/{category}', 'ProductsController@productsByCategory');
    Route::get('/products', 'ProductsController@searchProduct');
    Route::post('/orders/checkout', 'OrdersController@checkOut');
});