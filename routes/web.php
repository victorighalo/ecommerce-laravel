<?php

Auth::routes();

//Admin section
Route::get('/office', 'OfficeController@office');

//Products
Route::get('/office/products', 'ProductsController@index');
Route::get('/office/products/activate/{id?}', 'ProductsController@activate')->name('activate_product');
Route::get('/office/products/deactivate/{id?}', 'ProductsController@deactivate')->name('deactivate_product');
Route::get('/office/products/destroy/{product_id?}/{taxon_id?}', 'ProductsController@destroy')->name('destroy_product');
Route::get('/office/products/json', 'ProductsController@getProductsData')->name('get_products');
Route::post('/office/products/create', 'ProductsController@create')->name('create_products');
Route::get('/office/product/{id}/edit', 'ProductsController@edit')->name('edit_product');
Route::post('/office/product/update', 'ProductsController@update')->name('update_product');

//Media
Route::post('/office//media/upload', 'MediaController@UploadMedia')->name('media_upload');
Route::get('/office/media/images/load', 'MediaController@loadImages')->name('load_images');
Route::post('/office/media/remove', 'MediaController@destroy')->name('media_remove');
Route::post('/office/media/remove_spatie', 'MediaController@destroySpatieMedia')->name('media_remove_spatie');

//Categories
Route::get('/office/category', 'CategoryController@index');
Route::get('/office/category/json', 'CategoryController@getTaxonomiesJson')->name('load_categories');
Route::get('/office/subcategory/destroy/{id?}', 'CategoryController@destroyTaxon')->name('destroy_subcategory');
Route::post('/office/subcategory/edit', 'CategoryController@editTaxon')->name('edit_subcategory');
Route::post('/office/category/edit', 'CategoryController@editTaxonomy')->name('edit_category');
Route::get('/office/category/destroy/{id?}', 'CategoryController@destroyTaxonomy')->name('destroy_category');
Route::post('/office/category/create', 'CategoryController@create')->name('create_category');
Route::post('/office/category/create_sub_category', 'CategoryController@createSubCategory')->name('create_sub_category');


//Frontend
Route::get('/', 'HomeController@index');
Route::get('/{taxon_slug}', 'PagesController@getProductList')->name('getCategoryContent');
Route::get('/{taxon_slug}/{product_slug}', 'PagesController@getProductDetails')->name('getProductDetails');

//Cart
Route::post('/cart/add', 'CartController@add')->name('add_to_cart');

