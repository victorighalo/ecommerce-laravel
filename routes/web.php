<?php

Route::get('/', 'PagesController@home');

Route::get('install', 'SettingController@install')->name('install');
Route::post('install', 'SettingController@store');

Auth::routes();


Route::get('/checkout', 'CheckoutController@index');
Route::post('/checkout', 'PaymentController@initializePayStackTrans');

//Cart
Route::get('/cart', 'CartController@index');
Route::post('/cart/add', 'CartController@add')->name('add_to_cart');
Route::post('/cart/update/{cart_item?}', 'CartController@update')->name('update_cart');
Route::post('/cart/destroy/{cart_item?}', 'CartController@destroy')->name('destroy_cart');

//Common
Route::post('/load_cities', 'CommonController@loadCities')->name('load_cities');
Route::post('/add_address', 'CommonController@addAddress')->name('add_address');

Route::group(['prefix' => 'office'], function (){

//Admin section
    Route::get('/', 'OfficeController@office');

//Products
Route::get('/products', 'ProductsController@index');
Route::get('/products/activate/{id?}', 'ProductsController@activate')->name('activate_product');
Route::get('/products/deactivate/{id?}', 'ProductsController@deactivate')->name('deactivate_product');
Route::get('/products/destroy/{product_id?}/{taxon_id?}', 'ProductsController@destroy')->name('destroy_product');
Route::get('/products/json', 'ProductsController@getProductsData')->name('get_products');
Route::post('/products/create', 'ProductsController@create')->name('create_products');
Route::get('/product/{id}/edit', 'ProductsController@edit')->name('edit_product');
Route::post('/product/update', 'ProductsController@update')->name('update_product');

//Media
Route::post('/media/upload', 'MediaController@UploadMedia')->name('media_upload');
Route::get('/media/images/load', 'MediaController@loadImages')->name('load_images');
Route::post('/media/remove', 'MediaController@destroy')->name('media_remove');
Route::post('/media/remove_spatie', 'MediaController@destroySpatieMedia')->name('media_remove_spatie');

//Categories
Route::get('/category', 'CategoryController@index');
Route::get('/category/json', 'CategoryController@getTaxonomiesJson')->name('load_categories');
Route::get('/subcategory/destroy/{id?}', 'CategoryController@destroyTaxon')->name('destroy_subcategory');
Route::post('/subcategory/edit', 'CategoryController@editTaxon')->name('edit_subcategory');
Route::post('/category/edit', 'CategoryController@editTaxonomy')->name('edit_category');
Route::get('/category/destroy/{id?}', 'CategoryController@destroyTaxonomy')->name('destroy_category');
Route::post('/category/create', 'CategoryController@create')->name('create_category');
Route::post('/category/create_sub_category', 'CategoryController@createSubCategory')->name('create_sub_category');

//Properties
Route::get('/properties', 'PropertyController@index');
Route::post('/properties/create', 'PropertyController@create')->name('create_property');
Route::post('/properties/update', 'PropertyController@update')->name('update_property');
Route::post('/properties/updatevalue', 'PropertyController@updateValue')->name('update_property_value');
Route::post('/properties/updatetitle', 'PropertyController@updateTitle')->name('update_property_title');
Route::post('/properties/value/create', 'PropertyController@createPropertyValue')->name('create_property_value');
Route::get('/properties/json', 'PropertyController@getPropertiesJson')->name('load_properties');


//App Settings
Route::get('/settings', 'SettingController@index');
Route::put('/settings/update', 'SettingController@update');
});

//Frontend
Route::get('/{taxon_slug}', 'PagesController@getProductList')->name('getCategoryContent');
Route::get('/{taxon_slug}/{product_slug}', 'PagesController@getProductDetails')->name('getProductDetails');

Route::post('/product/comment/add/{product_id?}', 'ProductsController@addComment')->name('add_comment');
Route::post('/product/rating/add', 'ProductsController@addRating')->name('rate_product');

Route::post('/cart/add', 'CartController@add')->name('add_to_cart');
Route::post('/cart/update/{cart_item?}', 'CartController@update')->name('update_cart');
Route::post('/cart/destroy/{cart_item?}', 'CartController@destroy')->name('destroy_cart');
