<?php



Auth::routes();

Route::get('/', 'HomeController@index');
Route::get('/office', 'OfficeController@office');
Route::get('/office/category', 'CategoryController@index');
Route::get('/office/products', 'ProductsController@index');
Route::post('/office/products/create', 'ProductsController@create')->name('create_products');
Route::post('/office/category/create', 'CategoryController@create')->name('create_category');
Route::post('/office/upload/product', 'MediaController@UploadMedia')->name('upload_product');
Route::get('/office/media/images/load', 'MediaController@loadImages')->name('load_images');
Route::post('/office/category/create_sub_category', 'CategoryController@createSubCategory')->name('create_sub_category');
