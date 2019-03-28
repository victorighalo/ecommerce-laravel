<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('/cart/add', 'CartController@add')->name('add_to_cart');
Route::post('/cart/update/{cart_item?}', 'CartController@update')->name('update_cart');
Route::post('/cart/destroy/{cart_item?}', 'CartController@destroy')->name('destroy_cart');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
