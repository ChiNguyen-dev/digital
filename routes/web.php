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

    /**
     * Authentication.
     * Login and Logout, Register.
     */
    Route::get('/login', [
        'as' => 'Client.login',
        'uses' => 'Authentication\SellController@index'
    ]);
    Route::post('/login', [
        'as' => 'Client.login',
        'uses' => 'Authentication\SellController@store'
    ]);
    Route::get('/logout', [
        'as' => 'Client.logout',
        'uses' => 'Authentication\SellController@logout'
    ]);
    Route::get('/register', [
        'as' => 'Client.register',
        'uses' => 'Authentication\SellController@create'
    ]);
    Route::post('/register', [
        'as' => 'Client.register',
        'uses' => 'Authentication\SellController@register'
    ]);

    /**
     * Home Route
     */
    Route::get('/', [
        'as' => 'client.home',
        'uses' => 'Client\HomeController@index'
    ]);
    Route::post('/search', [
        'as' => 'home.search',
        'uses' => 'Client\HomeController@search'
    ]);

    /**
     * Category Route
     */
    Route::get('/danh-muc/{cateSlug}', [
        'as' => 'products.category',
        'uses' => 'Client\ProductController@index'
    ]);

    /**
     * Product Route
     */
    Route::get('/san-pham/{slug}', [
        'as' => 'products.detail',
        'uses' => 'Client\ProductController@detailItem'
    ]);

    /**
     * Shopping Router Add To Cart
     */
    Route::post('/gio-hang/add/{id}', [
        'as' => 'carts.add',
        'uses' => 'Client\CartController@store'
    ]);

    Route::group(['middleware' => ['sell.auth']], function () {
        /**
         * Shopping Router Authentication
         */
        Route::prefix('/gio-hang')->group(function () {
            Route::get('/', [
                'as' => 'carts.index',
                'uses' => 'Client\CartController@index'
            ]);
            Route::get('/delete', [
                'as' => 'carts.destroy',
                'uses' => 'Client\CartController@destroy'
            ]);
            Route::delete('/delete/{id}', [
                'as' => 'carts.remove',
                'uses' => 'Client\CartController@remove'
            ]);
            Route::put('/update/{id}', [
                'as' => 'carts.updateQuantity',
                'uses' => 'Client\CartController@updateQuantity'
            ]);
            Route::put('/update/{id}/color', [
                'as' => 'carts.updateColor',
                'uses' => 'Client\CartController@updateColor'
            ]);
        });

        /**
         * Checkout Router Authentication
         */
        Route::get('/thanh-toan', [
            'as' => 'checkout.index',
            'uses' => 'Client\CheckoutController@index'
        ]);

        /**
         * Order Router Authentication
         */
        Route::post('/dat-hang', [
            'as' => 'orders.store',
            'uses' => 'Client\OrderController@store'
        ]);

        /**
         * Account Router Authentication
         */
        Route::prefix('/tai-khoan')->group(function () {
            Route::get('/', [
                'as' => 'account.account',
                'uses' => 'Client\AccountController@account'
            ]);
            Route::post('/', [
                'as' => 'account.account',
                'uses' => 'Client\AccountController@updateAccount',
            ]);
            Route::post('/validate', [
                'as' => 'account.validate',
                'uses' => 'Client\AccountController@validation',
            ]);
            Route::post('/address', [
                'as' => 'account.address',
                'uses' => 'Client\AccountController@chooseAddress',
            ]);
        });
    });
});
