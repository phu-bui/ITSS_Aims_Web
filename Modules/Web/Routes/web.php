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

Route::group(['prefix' => '', 'namespace' => '\Modules\Web\Http\Controllers'], function() {
    Route::get('/', 'HomeController@index')->name('web.home');
    Route::get('/cart', 'ProductController@cart')->name('web.cart');
   // Route::get('/search-order', 'HomeController@searchOrder')->name('web.search-order');
    //Route::get('/detail', 'HomeController@detail')->name('web.products-detail');
   // Route::get('/about-us', 'HomeController@aboutUs')->name('web.about-us');

    //search product

    // Route::post('/search', 'ProductController@search')->name('web.search');
    Route::get('/search', 'ProductController@search')->name('web.search');

    //shopping cart
    Route::get('/addcart/{id}', 'ProductController@addCart')->name('web.add_cart');
    Route::get('/Delete-Item-Cart/{id}', 'ProductController@DeleteItemCart')->name('web.delete_item_cart');
    Route::get('/Delete-One/{id}', 'ProductController@deleteOneItem')->name('web.delete_one');

});
Route::group(['prefix' => '', 'namespace' => '\Modules\Web\Http\Controllers\Auth'], function() {
    Route::get('/login', 'LoginController@showLoginForm')->name('web.login');
    Route::post('/login', 'LoginController@login')->name('web.post-login');
    Route::post('/register', 'RegisterController@register')->name('web.post-register');
    Route::get('/logout', 'LoginController@logout')->name('web.logout');
    //User
    Route::get('/profile/{user_id}', 'LoginController@view_account')->name('web.profile');
    Route::get('profile/update-profile/{user_id}', 'LoginController@update_profile')->name('web.update_profile');
    Route::get('profile/update-password/{user_id}', 'LoginController@update_password')->name('web.update_password');
    Route::get('profile/save-update-password/{user_id}', 'LoginController@save_update_password')->name('web.save_update_password');

});

//Checkout
Route::get('/login-checkout', 'CheckoutController@login_checkout')->name('web.login-checkout');
Route::get('/checkout', 'CheckoutController@checkout')->name('web.checkout');
Route::get('/show-checkout/{user_id}', 'CheckoutController@show_checkout')->name('web.show_checkout');
Route::get('/save-checkout-customer', 'CheckoutController@save_checkout_customer')->name('web.save-checkout-customer');
Route::get('/payment', 'CheckoutController@payment')->name('web.payment');
Route::get('/order-place', 'CheckoutController@order_place')->name('web.order-place');
Route::get('/test', 'CheckoutController@test');

//Category
Route::get('/category/{cate_name}' ,'CategoryController@show_category_home')->name('web.category_home');
Route::get('/product-detail/{product_slug}','ProductController@product_detail')->name('web.product_detail');

//Order
Route::get('/order-history','OrderController@order_history')->name('web.order_history');
Route::get('/order-remove/{ordered_id}', 'OrderController@order_cancellation')->name('web.order_remove');
Route::get('/view-order-detail/{ordered_id}', 'OrderController@view_order_detail')->name('web.view_order_detail');

#how to make custom library on laravel
