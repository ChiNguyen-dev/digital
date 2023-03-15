<?php

namespace App\Providers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Repositories\Imp\CategoryRepositoryImp;
use App\Repositories\Imp\ProductRepositoryImp;
use App\Repositories\Imp\SliderRepositoryImp;
use App\Repositories\Interfaces\ICategoryRepository;
use App\Repositories\Interfaces\IProductRepository;
use App\Repositories\Interfaces\ISliderRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Cart::class, function () {
            return new Cart();
        });
        $this->app->singleton(CartItem::class, function () {
            return new CartItem();
        });

        $this->app->singleton(
            IProductRepository::class,
            ProductRepositoryImp::class
        );
        $this->app->singleton(
            ISliderRepository::class,
            SliderRepositoryImp::class
        );
        $this->app->singleton(
            ICategoryRepository::class,
            CategoryRepositoryImp::class
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
