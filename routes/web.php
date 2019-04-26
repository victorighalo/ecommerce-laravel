<?php

Route::get('/', 'PagesController@home');
Route::get('/home', 'PagesController@home');

Route::get('install', 'SettingController@install')->name('install');
Route::post('install', 'SettingController@store');

Route::get('/profile', 'PagesController@profile')->middleware('auth');
Route::post('/profile', 'CommonController@updateProfile')->middleware('auth');

Route::get('/change_password', 'PagesController@changePassword')->middleware('auth');
Route::post('/change_password', 'CommonController@changePassword')->middleware('auth');

Route::get('email-test', function(){

    $details['email'] = 'victorighalo@live.com';

    dispatch(new App\Jobs\SendEmailJob($details));

    dd('done');
});

Route::get('aws-test', function(){

    try {
        $url = 'https://s3.' . env('AWS_DEFAULT_REGION') . '.amazonaws.com/' . env('AWS_BUCKET') . '/';
        $images = [];
        $files = Storage::disk('s3')->files('images');
        foreach ($files as $file) {
            $images[] = [
                'name' => str_replace('images/', '', $file),
                'src' => $url . $file
            ];
        }
        dd($images);
    }catch (\Exception $e){
        var_dump($e->getMessage());
    }
});
Auth::routes();

//Checkout
Route::get('/checkout', 'CheckoutController@index');
Route::get('/contact', 'CommonController@contact');
Route::get('/about', 'CommonController@about');
Route::post('/checkout', 'Payment\PaymentController@initializePayStackTrans');

//Search Product
Route::get('search', 'SearchController@searchProduct')->name('search_product');

//Cart
Route::get('/cart', 'CartController@index');
Route::post('/cart/add', 'CartController@add')->name('add_to_cart');
Route::post('/cart/update/{cart_item?}', 'CartController@update')->name('update_cart');
Route::post('/cart/destroy/{cart_item?}', 'CartController@destroy')->name('destroy_cart');

//Common
Route::post('/load_cities', 'CommonController@loadCities')->name('load_cities');
Route::post('/add_address', 'CommonController@addAddress')->name('add_address');


//Office section
Route::group(['prefix' => 'office', 'middleware' => ['role:admin']], function (){

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
Route::post('/product/properties/update/{id?}', 'ProductsController@updateProperties')->name('update_product_properties');
Route::post('/media/remove_product', 'ProductsController@removePhoto')->name('remove_product_media');

//Media
Route::post('/media/upload', 'MediaController@UploadMedia')->name('media_upload');
Route::get('/media/images/load', 'MediaController@loadImages')->name('load_images');
Route::post('/media/remove', 'MediaController@destroyMedia')->name('media_remove');

//Categories
Route::get('/category', 'CategoryController@index');
Route::get('/category/json', 'CategoryController@getTaxonomiesJson')->name('load_categories');
Route::get('/subcategory/destroy/{id?}', 'CategoryController@destroyTaxon')->name('destroy_subcategory');
Route::post('/subcategory/edit', 'CategoryController@editTaxon')->name('edit_subcategory');
Route::post('/category/edit', 'CategoryController@editTaxonomy')->name('edit_category');
Route::get('/category/destroy/{id?}', 'CategoryController@destroyTaxonomy')->name('destroy_category');
Route::post('/category/create', 'CategoryController@create')->name('create_category');
Route::post('/category/create_sub_category', 'CategoryController@createSubCategory')->name('create_sub_category');
Route::post('/category/create_child_category', 'CategoryController@createChildCategory')->name('create_child_category');

//Properties
Route::get('/properties', 'PropertyController@index');
Route::post('/properties/create', 'PropertyController@create')->name('create_property');
Route::post('/properties/update', 'PropertyController@update')->name('update_property');
Route::get('/properties/destroy/{id?}', 'PropertyController@destroy')->name('destroy_property');
Route::get('/properties/value/destroy/{id?}', 'PropertyController@destroyPropVal')->name('destroy_property_value');
Route::post('/properties/updatevalue', 'PropertyController@updateValue')->name('update_property_value');
Route::post('/properties/updatetitle', 'PropertyController@updateTitle')->name('update_property_title');
Route::post('/properties/value/create', 'PropertyController@createPropertyValue')->name('create_property_value');
Route::get('/properties/json', 'PropertyController@getPropertiesJson')->name('load_properties');


//App Settings
Route::get('/settings', 'SettingController@index');
Route::put('/settings/update', 'SettingController@update');
});

//Frontend
Route::get('/{taxon_slug}', 'PagesController@getProductList')->name('get_category_content');
Route::get('/{taxon_slug}/{product_slug}', 'PagesController@getProductDetails')->name('getProductDetails');

Route::post('/product/comment/add/{product_id?}', 'ProductsController@addComment')->name('add_comment');
Route::post('/product/rating/add', 'ProductsController@addRating')->name('rate_product');

Route::post('/cart/add', 'CartController@add')->name('add_to_cart');
Route::post('/cart/update/{cart_item?}', 'CartController@update')->name('update_cart');
Route::post('/cart/destroy/{cart_item?}', 'CartController@destroy')->name('destroy_cart');


