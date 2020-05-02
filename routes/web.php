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

Route::get('/', 'userController@index');
Route::resource('/product', 'productController');
Route::resource('/promo', 'promoController');
Route::get('/user', 'userController@create');
Route::post('/user', 'userController@store');
Route::get('/product-list', 'productController@list');
Route::post('/promo-list', 'promoController@list');
Route::post('/cart', 'cartController@store');

