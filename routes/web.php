<?php



Auth::routes();

Route::get('/', 'HomeController@index');
Route::get('/office', 'OfficeController@office');
Route::get('/office/category', 'CategoryController@index');
Route::post('/office/category/create', 'CategoryController@create')->name('create_category');
