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

Route::group(['middleware' => 'web', 'prefix' => 'admin', 'namespace' => '\Modules\Admin\Http\Controllers'], function()
{
    Route::group(['middleware' => 'auth.admin'], function() {
        Route::get('/', 'AdminController@index')->name('admin.index');
        Route::get('/logout', 'Auth\LoginController@logout')->name('admin.logout');

        //Product
        Route::get('/products', 'ProductController@index')->name('admin.products.list');
        Route::get('/add-products', 'ProductController@add_product')->name('admin.add_product');
        Route::get('/add-property/{category_id}', 'ProductController@add_property')->name('admin.product.add_property');
        Route::get('/save-products', 'ProductController@save_product')->name('admin.save_product');
        Route::get('/edit-products/{product_id}', 'ProductController@edit_product')->name('admin.edit_product');
        Route::post('/update-products/{product_id}', 'ProductController@update_product')->name('admin.update_product');
        Route::post('/update-property/{product_id}', 'ProductController@update_property')->name('admin.update_property');
        Route::get('/delete-products/{product_id}', 'ProductController@delete_product')->name('admin.delete_product');

        Route::post('/delete-list-product', 'ProductController@delete_list_product')->name('admin.delete_list_product');


        Route::get('/category/{cate_name}' ,'ProductController@show_category_home')->name('admin.category_home');



        //Category
        Route::get('/categories', 'CategoryController@index')->name('admin.categories.list');
        Route::get('/add-categories', 'CategoryController@add_category')->name('admin.add_category');
        Route::post('/save-categories', 'CategoryController@save_category')->name('admin.save_category');
        Route::get('/edit-categories/{category_id}', 'CategoryController@edit_category')->name('admin.edit_category');
        Route::post('/update-categories/{category_id}', 'CategoryController@update_category')->name('admin.update_category');
        Route::get('/delete-categories/{category_id}', 'CategoryController@delete_category')->name('admin.delete_category');
        //Category
       

        //User
        Route::get('/users', 'UserController@index')->name('admin.users.list');
        Route::get('/delete-users/{user_id}', 'UserController@delete_user')->name('admin.delete_user');

        //Order
        Route::get('orders', 'OrderController@index')->name('admin.orders.list');
        Route::get('delete-orders/{order_id}', 'OrderController@delete_order')->name('admin.delete_order');
        Route::get('view-order/{order_id}', 'OrderController@view_order')->name('admin.view_order');
        Route::get('order-approval/{order_id}', 'OrderController@order_approval')->name('admin.order_approval');

        //History
        Route::get('/history', 'HistoryController@index')->name('admin.history');





    });
    // redirect if has login
    Route::group(['middleware' => 'guest:admin,admin.index'], function() {
        Route::get('/login', 'Auth\LoginController@showLoginForm')->name('admin.login');
        Route::post('/login', 'Auth\LoginController@login')->name('admin.post-login');
    });

});

