<?php



Auth::routes();

Route::get('/', 'HomeController@index');
Route::get('/office', 'OfficeController@office');
Route::get('/office/category', 'CategoryController@index');
Route::get('/office/products', 'ProductsController@index');
Route::get('/office/products/activate/{id?}', 'ProductsController@activate')->name('activate_product');
Route::get('/office/products/deactivate/{id?}', 'ProductsController@deactivate')->name('deactivate_product');
Route::get('/office/products/destroy/{product_id?}/{taxon_id?}', 'ProductsController@destroy')->name('destroy_product');
Route::get('/office/products/json', 'ProductsController@getProductsData')->name('get_products');
Route::post('/office/products/create', 'ProductsController@create')->name('create_products');
Route::post('/office/category/create', 'CategoryController@create')->name('create_category');
Route::post('/office//media/upload', 'MediaController@UploadMedia')->name('media_upload');
Route::get('/office/media/images/load', 'MediaController@loadImages')->name('load_images');
//Route::post('/office/media/remove', 'MediaController@destroy')->name('media_remove');
Route::post('/office/category/create_sub_category', 'CategoryController@createSubCategory')->name('create_sub_category');

