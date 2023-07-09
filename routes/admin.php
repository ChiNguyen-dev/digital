<?php

use Illuminate\Support\Facades\Route;

Route::get('/login', [
    'as' => 'admin.login',
    'uses' => 'Authentication\AdminController@index'
]);
Route::post('/login', [
    'as' => 'admin.login',
    'uses' => 'Authentication\AdminController@store'
]);
Route::group(['middleware' => ['admin.auth']], function () {
    Route::get('/', [
        'as' => 'admin.index',
        'uses' => 'Admin\AdminDashBoardController@index'
    ]);
    Route::get('/dashboard', [
        'as' => 'admin.dashboard',
        'uses' => 'Admin\AdminDashBoardController@index'
    ]);
    Route::get('/logout', [
        'as' => 'admin.logout',
        'uses' => 'Authentication\AdminController@logout'
    ]);
    /**
     * Customer
     */
    Route::prefix('/customer')->group(function () {
        Route::get('/', [
            'as' => 'customer.index',
            'uses' => 'Admin\AdminCustomerController@index',
            'middleware' => 'can:customer-show'
        ]);
        Route::post('/delete', [
            'as' => 'customer.delete',
            'uses' => 'Admin\AdminCustomerController@delete',
            'middleware' => 'can:customer-delete',
        ]);
    });

    /**
     * Order
     */
    Route::prefix('/orders')->group(function () {
        Route::get('/', [
            'as' => 'orders.index',
            'uses' => 'Admin\AdminOrderController@index',
            'middleware' => 'can:order-show'
        ]);
        Route::post('/', [
            'as' => 'orders.index',
            'uses' => 'Admin\AdminOrderController@index',
        ]);
        Route::get('/{id}', [
            'as' => 'orders.detail',
            'uses' => 'Admin\AdminOrderController@detail',
        ]);
        Route::post('/update', [
            'as' => 'orders.update',
            'uses' => 'Admin\AdminOrderController@update',
            'middleware' => 'can:order-update'
        ]);
        Route::post('/search', [
            'as' => 'orders.search',
            'uses' => 'Admin\AdminOrderController@search',
            'middleware' => 'can:order-show'
        ]);
    });

    /**
     * Slider
     */
    Route::prefix('sliders')->group(function () {
        Route::get('/', [
            'as' => 'sliders.index',
            'uses' => 'Admin\AdminSliderController@index',
            'middleware' => 'can:slider-show'
        ]);
        Route::post('/store', [
            'as' => 'sliders.store',
            'uses' => 'Admin\AdminSliderController@store'
        ]);
        Route::get('/delete/{id}', [
            'as' => 'sliders.delete',
            'uses' => 'Admin\AdminSliderController@delete',
            'middleware' => 'can:slider-delete'
        ]);
        Route::get('/edit/{id}', [
            'as' => 'sliders.edit',
            'uses' => 'Admin\AdminSliderController@edit',
            'middleware' => 'can:slider-edit'
        ]);
        Route::post('/update/{id}', [
            'as' => 'sliders.update',
            'uses' => 'Admin\AdminSliderController@update'
        ]);
    });

    /**
     * Product
     */
    Route::prefix('product')->group(function () {
        Route::get('/', [
            'as' => 'product.index',
            'uses' => 'Admin\AdminProductController@index',
            'middleware' => 'can:product-show'
        ]);
        Route::post('/', [
            'as' => 'product.index',
            'uses' => 'Admin\AdminProductController@index'
        ]);
        Route::get('/create', [
            'as' => 'product.create',
            'uses' => 'Admin\AdminProductController@create',
            'middleware' => 'can:product-add'
        ]);
        Route::post('/store', [
            'as' => 'product.store',
            'uses' => 'Admin\AdminProductController@store'
        ]);
        Route::get('/edit/{id}', [
            'as' => 'product.edit',
            'uses' => 'Admin\AdminProductController@edit'
        ]);
        Route::post('/update/{id}', [
            'as' => 'product.update',
            'uses' => 'Admin\AdminProductController@update'
        ]);
        Route::get('/delete/{id}', [
            'as' => 'product.delete',
            'uses' => 'Admin\AdminProductController@delete',
        ]);
        Route::post('/update', [
            'as' => 'product.updateStatus',
            'uses' => 'Admin\AdminProductController@updateStatus',
        ]);
    });

    /**
     * Color
     */
    Route::prefix('colors')->group(function () {
        Route::get('/', [
            'as' => 'color.index',
            'uses' => 'Admin\AdminColorController@index',
            'middleware' => 'can:color-show'
        ]);
        Route::post('/store', [
            'as' => 'color.store',
            'uses' => 'Admin\AdminColorController@store'
        ]);
        Route::get('/edit/{id}', [
            'as' => 'color.edit',
            'uses' => 'Admin\AdminColorController@edit'
        ]);
        Route::post('/update/{id}', [
            'as' => 'color.update',
            'uses' => 'Admin\AdminColorController@update'
        ]);
        Route::post('/delete', [
            'as' => 'color.delete',
            'uses' => 'Admin\AdminColorController@delete'
        ]);
    });

    /**
     * Category
     */
    Route::prefix('categories')->group(function () {
        Route::get('/', [
            'as' => 'categories.index',
            'uses' => 'Admin\AdminCategoryController@index',
            'middleware' => 'can:category-show'
        ]);
        Route::get('/edit/{id}', [
            'as' => 'categories.edit',
            'uses' => 'Admin\AdminCategoryController@edit',
            'middleware' => 'can:category-edit'
        ]);
        Route::post('/update/{id}', [
            'as' => 'categories.update',
            'uses' => 'Admin\AdminCategoryController@update'
        ]);
        Route::post('/delete', [
            'as' => 'categories.delete',
            'uses' => 'Admin\AdminCategoryController@delete',
            'middleware' => 'can:category-delete'
        ]);
        Route::post('/store', [
            'as' => 'categories.store',
            'uses' => 'Admin\AdminCategoryController@store'
        ]);
    });
    /**
     * User
     */
    Route::prefix('users')->group(function () {
        Route::get('/', [
            'as' => 'users.index',
            'uses' => 'Admin\AdminUserController@index'
        ]);
        Route::get('/create', [
            'as' => 'users.create',
            'uses' => 'Admin\AdminUserController@create'
        ]);
        Route::post('/store', [
            'as' => 'users.store',
            'uses' => 'Admin\AdminUserController@store'
        ]);
        Route::get('/edit/{id}', [
            'as' => 'users.edit',
            'uses' => 'Admin\AdminUserController@edit'
        ]);
        Route::post('/update/{id}', [
            'as' => 'users.update',
            'uses' => 'Admin\AdminUserController@update'
        ]);
        Route::get('/delete/{id}', [
            'as' => 'users.delete',
            'uses' => 'Admin\AdminUserController@delete'
        ]);

        Route::get('/account', [
            'as' => 'users.account',
            'uses' => 'Admin\AdminUserController@account'
        ]);
        Route::post('/account/update/{id}', [
            'as' => 'users.account.update',
            'uses' => 'Admin\AdminUserController@accountUpdate'
        ]);

        Route::get('/editPassword', function () {
            return view('admin.users.changePass');
        })->name('users.editPassword');

        Route::post('/changePassword/{id}', [
            'as' => 'users.changePassword',
            'uses' => 'Admin\AdminUserController@changePassword'
        ]);

        Route::get('/search', [
            'as' => 'users.search',
            'uses' => 'Admin\AdminUserController@index'
        ]);
        Route::post('/search', [
            'as' => 'users.search',
            'uses' => 'Admin\AdminUserController@index'
        ]);
    });

    /**
     * Role
     */
    Route::prefix('roles')->group(function () {
        Route::get('/', [
            'as' => 'roles.index',
            'uses' => 'Admin\AdminRoleController@index'
        ]);
        Route::get('/create', [
            'as' => 'roles.create',
            'uses' => 'Admin\AdminRoleController@create'
        ]);
        Route::post('/store', [
            'as' => 'roles.store',
            'uses' => 'Admin\AdminRoleController@store'
        ]);
        Route::get('/edit/{id}', [
            'as' => 'roles.edit',
            'uses' => 'Admin\AdminRoleController@edit'
        ]);
        Route::post('/update/{id}', [
            'as' => 'roles.update',
            'uses' => 'Admin\AdminRoleController@update'
        ]);
        Route::get('/delete/{id}', [
            'as' => 'roles.delete',
            'uses' => 'Admin\AdminRoleController@delete'
        ]);
    });

    /**
     * Permission
     */
    Route::prefix('/permissions')->group(function () {
        Route::get('/', [
            'as' => 'permissions.index',
            'uses' => 'Admin\AdminPermissionController@index'
        ]);
        Route::get('/create', [
            'as' => 'permissions.create',
            'uses' => 'Admin\AdminPermissionController@create'
        ]);
        Route::post('/store', [
            'as' => 'permissions.store',
            'uses' => 'Admin\AdminPermissionController@store'
        ]);
        Route::get('/edit/{id}', [
            'as' => 'permissions.edit',
            'uses' => 'Admin\AdminPermissionController@edit'
        ]);
        Route::post('/update/{id}', [
            'as' => 'permissions.update',
            'uses' => 'Admin\AdminPermissionController@update'
        ]);
        Route::get('/delete/{id}', [
            'as' => 'permissions.delete',
            'uses' => 'Admin\AdminPermissionController@delete'
        ]);
    });
});


