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
            // 'middleware' => 'isLogin'
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