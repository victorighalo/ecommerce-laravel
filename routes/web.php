<?php

use App\Mail\TestAmazonSes;
use Illuminate\Support\Facades\Mail;

Route::get('/', 'PagesController@home')->name('home');
Route::get('/home', 'PagesController@home');
Route::post('/payment/paystack/verify', 'WebHook\WebHookController@PaystackWebhook');

Route::get('install', 'SettingController@install')->name('install');
Route::post('install', 'SettingController@store');

Route::get('/profile', 'PagesController@profile')->middleware('auth');
Route::post('/profile', 'CommonController@updateProfile')->middleware('auth');

Route::get('/change_password', 'PagesController@changePassword')->middleware('auth');
Route::post('/change_password', 'CommonController@changePassword')->middleware('auth');

Route::get('brand/{taxonomy_slug}', 'PagesController@getBrandProducts')->name('get_brand');

Route::get('email-test', function(){

    $details['email'] = 'victorighalo@live.com';

    \App\Jobs\SendEmailJob::dispatch($details);

});

Route::get('test', function () {
    Mail::to('victorighalo@gmail.com')->send(new TestAmazonSes('It Works'));
});



Auth::routes();

//Checkout
Route::get('/checkout', 'CheckoutController@index');
Route::get('/contact', 'CommonController@contact');
Route::get('/about', 'CommonController@about');
Route::post('/checkout', 'Payment\PaymentController@initializePayStackTrans');
Route::get('/transaction/success', 'Payment\PaymentController@successReport');

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
Route::post('get_delivery_cost', 'DeliverySettingsController@getDeliveryCost')->name('get_delivery_cost');

//Office section
Route::group(['prefix' => 'office', 'middleware' => ['role:admin']], function (){

Route::get('/', 'OfficeController@office');

//Dashboard
Route::get('dashboard', 'OfficeController@dashboard');
Route::post('get_store_stats', 'OfficeController@getStoreStats')->name('get_store_stats');

//Orders
Route::get('orders', 'OfficeController@orders');
Route::get('orders/data', 'OfficeController@ordersData')->name('orders_data');
Route::post('orders/products', 'OfficeController@ordersProducts')->name('order_products');

//Transactions
    Route::get('transactions', 'OfficeController@transactions');

//Products
Route::get('/products/list', 'ProductsController@index');
Route::get('/products/add', 'ProductsController@addProduct');
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
Route::post('/photo/remove', 'MediaController@destroyLocalPhoto')->name('photo_remove');
Route::post('/slider/update/{id}/{status}', 'MediaController@toggleSlider');

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
Route::post('/category/upload/image', 'CategoryController@addTaxonImage')->name('upload_category_image');

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
Route::post('/settings/slider/upload', 'MediaController@uploadSliderImage')->name('upload_slider_image');


//Delivery settings
Route::get('delivery_data', 'DeliverySettingsController@getDeliveryCostData')->name('delivery_data');
Route::post('delivery_update', 'DeliverySettingsController@update')->name('delivery_update');
Route::resource('delivery', 'DeliverySettingsController');

//Users
Route::post('get_users', 'UsersController@getUsersData')->name('get_users');
Route::get('users/edit/{id}', 'UsersController@getUserData');
Route::put('users/update', 'UsersController@update')->name('update_user');
Route::put('users/deactivate/{id}', 'UsersController@deactivate');
Route::put('users/activate/{id}', 'UsersController@activate');
Route::put('users/destroy/{id}', 'UsersController@destroy');
Route::put('users/password/change', 'UsersController@changePassword')->name('update_user_password');
Route::resource('users', 'UsersController');
});

//Frontend
Route::get('/{taxon_slug}', 'PagesController@getProductList')->name('get_category_content');
Route::get('/{taxon_slug}/{product_slug}', 'PagesController@getProductDetails')->name('getProductDetails');


Route::post('/product/comment/add/{product_id?}', 'ProductsController@addComment')->name('add_comment');
Route::post('/product/rating/add', 'ProductsController@addRating')->name('rate_product');

Route::post('/cart/add', 'CartController@add')->name('add_to_cart');
Route::post('/cart/update/{cart_item?}', 'CartController@update')->name('update_cart');
Route::post('/cart/destroy/{cart_item?}', 'CartController@destroy')->name('destroy_cart');


