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
Route::get('success', 'ProductController@success')->name('success');
Route::get('failure', 'ProductController@failure')->name('failure');

Route::get('profile', 'ProductController@profile')->name('profile');
Route::get('userOrders', 'ProductController@userOrders')->name('userOrders');
// Route::get('contact', 'ProductController@contact')->name('contact');
Route::get('logoutUser', 'ProductController@logoutUser')->name('logoutUser');
Route::get('/', 'ProductController@show');

Route::get('/home', 'ProductController@show')->name('home');

Route::get('category/{category}','ProductController@category')->name('category');
Route::get('size/{size}','ProductController@size')->name('size');
Route::get('product', 'ProductController@index')->name('product');
// Route::get('product/{product}','ProductController@product')->name('product');
Route::get('/admin/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
Route::post('/admin/login', 'Auth\AdminLoginController@login');
Route::group(['namespace' => 'Admin'],function(){
	Route::get('admin/adminHome','HomeController@index')->name('admin.home');
	Route::post('toggledeliver/{orderId}', 'OrderController@toggledeliver')->name('toggle.deliver');
	Route::get('admin/orders/{type?}','OrderController@Orders');
});
Route::resource('admin/products','Admin\ProductController');
Route::post('images-upload', 'Admin\ProductController@imagesUploadPost')->name('images.upload');

Route::resource('admin/category','Admin\CategoryController');
Route::resource('admin/size','Admin\SizeController');
Route::resource('admin/gender','Admin\GenderController');

Route::get('/details{id}', 'ProductController@details')->name('details');
Route::get('shipping','User\CheckoutController@shipping')->name('checkout.shipping');
Route::post('details/buyNow{id}','User\CheckoutController@buyNow')->name('checkout.buyNow');
Route::resource('cart', 'User\CartController');
Route::post('/cart/store/{id}', 'User\CartController@store')->name('cart.store');
Route::post('/cart/storeBuy/{id}', 'User\CartController@storeBuy')->name('cart.storeBuy');
Route::resource('address','AddressController');
Route::post('addressUpdate','AddressController@updateAddress')->name('addressUpdate');
Route::post('storePayment{id}','User\CheckoutController@storePayment')->name('storePayment');
Route::get('paymentStatus','User\CheckoutController@paymentDetails');
Route::post('webhook','User\CheckoutController@updateOrder');

// Route::get('payment','User\CheckoutController@payment')->name('checkout.payment');
// Route::post('store-payment','User\CheckoutController@storePayment')->name('payment.store');
// });
// // Route::get('/products', 'User\ProductController@product')->name('product');
// Route::group(['namespace' => 'User'],function(){
//   // Route::get('/','HomeController@index');
//   // Route::get('product/{product}','ProductController@product')->name('product');
// });

Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');
