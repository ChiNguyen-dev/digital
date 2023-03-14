<?php

use Illuminate\Support\Facades\Route;

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

Route::prefix('/')->group(function () {

    Route::get('/login', [
        'as' => 'Client.login',
        'uses' => 'Authen\Client\AuthenController@index'
    ]);
    Route::post('/login', [
        'as' => 'Client.login',
        'uses' => 'Authen\Client\AuthenController@store'
    ]);
    Route::get('/logout', [
        'as' => 'Client.logout',
        'uses' => 'Authen\Client\AuthenController@logout'
    ]);


    Route::get('/register', [
        'as' => 'Client.register',
        'uses' => 'Authen\Client\AuthenController@register'
    ]);

    Route::get('/', [
        'as' => 'client.home',
        'uses' => 'HomeController@index'
    ]);

    Route::post('/search', [
        'as' => 'home.search',
        'uses' => 'HomeController@search'
    ]);

    Route::prefix('/danh-muc')->group(function () {
        Route::get('/{cateSlug}', [
            'as' => 'products.category',
            'uses' => 'ProductController@index'
        ]);
    });

    Route::prefix('/san-pham')->group(function () {
        Route::get('/{slug}', [
            'as' => 'products.detail',
            'uses' => 'ProductController@detailItem'
        ]);
    });

    Route::prefix('/gio-hang')->group(function () {
        Route::get('/', [
            'as' => 'carts.index',
            'uses' => 'CartController@index',
            'middleware' => 'isLogin'
        ]);
        Route::get('/add/{id}', [
            'as' => 'carts.add',
            'uses' => 'CartController@add'
        ]);
        Route::get('/delete', [
            'as' => 'carts.delete',
            'uses' => 'CartController@delete'
        ]);
        Route::get('/update/{id}', [
            'as' => 'carts.updateQty',
            'uses' => 'CartController@updateQty'
        ]);
        Route::get('/delete-item/{id}', [
            'as' => 'carts.deleteItem',
            'uses' => 'CartController@deleteItem'
        ]);
        Route::get('/update-color/{id}', [
            'as' => 'carts.updateColor',
            'uses' => 'CartController@updateColor'
        ]);
    });

    Route::prefix('/thanh-toan')->group(function () {
        Route::get('/', [
            'as' => 'checkout.index',
            'uses' => 'CheckoutController@index'
        ]);
        Route::post('/changeAddress', [
            'as' => 'checkout.changeAddress',
            'uses' => 'CheckoutController@changeAddress'
        ]);
    });

    Route::prefix('/dat-hang')->group(function () {
        Route::post('/store', [
            'as' => 'orders.store',
            'uses' => 'OrderController@store'
        ]);
    });

});

Route::prefix('/admin')->group(function () {
    Route::get('/', [
        'as' => 'admin.index',
        'uses' => 'AdminController@index'
    ]);
    Route::get('/home', [
        'as' => 'admin.dashboard',
        'uses' => 'AdminController@index'
    ]);
    Route::post('/login', [
        'as' => 'admin.login',
        'uses' => 'AdminController@store'
    ]);
    Route::get('/logout', [
        'as' => 'admin.logout',
        'uses' => 'AdminController@logout'
    ]);

    /**
     * Customer
     */
    Route::prefix('/customer')->group(function () {
        Route::get('/', [
            'as' => 'customer.index',
            'uses' => 'AdminCustomerController@index',
            'middleware' => 'can:customer-show'
        ]);
        Route::post('/delete', [
            'as' => 'customer.delete',
            'uses' => 'AdminCustomerController@delete',
            'middleware' => 'can:customer-delete',
        ]);
    });

    /**
     * Order
     */
    Route::prefix('/orders')->group(function () {
        Route::get('/', [
            'as' => 'orders.index',
            'uses' => 'AdminOrderController@index',
            'middleware' => 'can:order-show'
        ]);
        Route::post('/update', [
            'as' => 'orders.update',
            'uses' => 'AdminOrderController@update',
            'middleware' => 'can:order-update'
        ]);
        Route::get('/search', [
            'as' => 'orders.index',
            'uses' => 'AdminOrderController@index',
        ]);
        Route::post('/search', [
            'as' => 'orders.index',
            'uses' => 'AdminOrderController@index',
        ]);
        Route::get('/detail/{id}', [
            'as' => 'orders.detail',
            'uses' => 'AdminOrderController@detail',
        ]);
    });

    /**
     * Slider
     */
    Route::prefix('sliders')->group(function () {
        Route::get('/', [
            'as' => 'sliders.index',
            'uses' => 'AdminSliderController@index',
            'middleware' => 'can:slider-show'
        ]);
        Route::post('/store', [
            'as' => 'sliders.store',
            'uses' => 'AdminSliderController@store'
        ]);
        Route::get('/delete/{id}', [
            'as' => 'sliders.delete',
            'uses' => 'AdminSliderController@delete',
            'middleware' => 'can:slider-delete'
        ]);
        Route::get('/edit/{id}', [
            'as' => 'sliders.edit',
            'uses' => 'AdminSliderController@edit',
            'middleware' => 'can:slider-edit'
        ]);
        Route::post('/update/{id}', [
            'as' => 'sliders.update',
            'uses' => 'AdminSliderController@update'
        ]);
    });

    /**
     * Product
     */
    Route::prefix('product')->group(function () {
        Route::get('/', [
            'as' => 'product.index',
            'uses' => 'adminProductController@index',
            'middleware' => 'can:product-show'
        ]);
        Route::get('/create', [
            'as' => 'product.create',
            'uses' => 'adminProductController@create',
            'middleware' => 'can:product-add'
        ]);
        Route::post('/store', [
            'as' => 'product.store',
            'uses' => 'adminProductController@store'
        ]);
        Route::get('/edit/{id}', [
            'as' => 'product.edit',
            'uses' => 'adminProductController@edit',
            'middleware' => 'can:product-edit,id'
        ]);
        Route::post('/update/{id}', [
            'as' => 'product.update',
            'uses' => 'adminProductController@update'
        ]);
        Route::get('/delete/{id}', [
            'as' => 'product.delete',
            'uses' => 'adminProductController@delete',
            'middleware' => 'can:product-delete,id'
        ]);
        Route::post('/updateAll', [
            'as' => 'product.updateAll',
            'uses' => 'adminProductController@updateAll',
        ]);
        Route::post('/search', [
            'as' => 'product.search',
            'uses' => 'adminProductController@index'
        ]);
        Route::get('/search', [
            'as' => 'product.search',
            'uses' => 'adminProductController@index'
        ]);
    });

    /**
     * Color
     */
    Route::prefix('colors')->group(function () {
        Route::get('/', [
            'as' => 'color.index',
            'uses' => 'AdminColorController@index',
            'middleware' => 'can:color-show'
        ]);
        Route::post('/store', [
            'as' => 'color.store',
            'uses' => 'AdminColorController@store'
        ]);
        Route::get('/edit/{id}', [
            'as' => 'color.edit',
            'uses' => 'AdminColorController@edit'
        ]);
        Route::post('/update/{id}', [
            'as' => 'color.update',
            'uses' => 'AdminColorController@update'
        ]);
        Route::post('/delete', [
            'as' => 'color.delete',
            'uses' => 'AdminColorController@delete'
        ]);
    });

    /**
     * Category
     */
    Route::prefix('categories')->group(function () {
        Route::get('/', [
            'as' => 'categories.index',
            'uses' => 'adminCategoryController@index',
            'middleware' => 'can:category-show'
        ]);
        Route::get('/edit/{id}', [
            'as' => 'categories.edit',
            'uses' => 'adminCategoryController@edit',
            'middleware' => 'can:category-edit'
        ]);
        Route::post('/update/{id}', [
            'as' => 'categories.update',
            'uses' => 'adminCategoryController@update'
        ]);
        Route::post('/delete', [
            'as' => 'categories.delete',
            'uses' => 'adminCategoryController@delete',
            'middleware' => 'can:category-delete'
        ]);
        Route::post('/store', [
            'as' => 'categories.store',
            'uses' => 'adminCategoryController@store'
        ]);
    });
    /**
     * User
     */
    Route::prefix('users')->group(function () {
        Route::get('/', [
            'as' => 'users.index',
            'uses' => 'AdminUserController@index'
        ]);
        Route::get('/create', [
            'as' => 'users.create',
            'uses' => 'AdminUserController@create'
        ]);
        Route::post('/store', [
            'as' => 'users.store',
            'uses' => 'AdminUserController@store'
        ]);
        Route::get('/edit/{id}', [
            'as' => 'users.edit',
            'uses' => 'AdminUserController@edit'
        ]);
        Route::post('/update/{id}', [
            'as' => 'users.update',
            'uses' => 'AdminUserController@update'
        ]);
        Route::get('/delete/{id}', [
            'as' => 'users.delete',
            'uses' => 'AdminUserController@delete'
        ]);

        Route::get('/account', [
            'as' => 'users.account',
            'uses' => 'AdminUserController@account'
        ]);
        Route::post('/account/update/{id}', [
            'as' => 'users.account.update',
            'uses' => 'AdminUserController@accountUpdate'
        ]);

        Route::get('/editPassword', function () {
            return view('admin.users.changePass');
        })->name('users.editPassword');

        Route::post('/changePassword/{id}', [
            'as' => 'users.changePassword',
            'uses' => 'AdminUserController@changePassword'
        ]);

        Route::get('/search', [
            'as' => 'users.search',
            'uses' => 'AdminUserController@index'
        ]);
        Route::post('/search', [
            'as' => 'users.search',
            'uses' => 'AdminUserController@index'
        ]);
    });

    /**
     * Role
     */
    Route::prefix('roles')->group(function () {
        Route::get('/', [
            'as' => 'roles.index',
            'uses' => 'AdminRoleController@index'
        ]);
        Route::get('/create', [
            'as' => 'roles.create',
            'uses' => 'AdminRoleController@create'
        ]);
        Route::post('/store', [
            'as' => 'roles.store',
            'uses' => 'AdminRoleController@store'
        ]);
        Route::get('/edit/{id}', [
            'as' => 'roles.edit',
            'uses' => 'AdminRoleController@edit'
        ]);
        Route::post('/update/{id}', [
            'as' => 'roles.update',
            'uses' => 'adminRoleController@update'
        ]);
        Route::get('/delete/{id}', [
            'as' => 'roles.delete',
            'uses' => 'adminRoleController@delete'
        ]);
    });

    /**
     * Permission
     */
    Route::prefix('/permissions')->group(function () {
        Route::get('/', [
            'as' => 'permissions.index',
            'uses' => 'AdminPermissionController@index'
        ]);
        Route::get('/create', [
            'as' => 'permissions.create',
            'uses' => 'AdminPermissionController@create'
        ]);
        Route::post('/store', [
            'as' => 'permissions.store',
            'uses' => 'AdminPermissionController@store'
        ]);
        Route::get('/edit/{id}', [
            'as' => 'permissions.edit',
            'uses' => 'AdminPermissionController@edit'
        ]);
        Route::post('/update/{id}', [
            'as' => 'permissions.update',
            'uses' => 'AdminPermissionController@update'
        ]);
        Route::get('/delete/{id}', [
            'as' => 'permissions.delete',
            'uses' => 'AdminPermissionController@delete'
        ]);
    });
});
