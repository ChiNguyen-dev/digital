<?php

namespace App\Providers;

use App\Helpers\CategoryRecursive;
use App\Models\Cart;
use App\Models\CartItem;
use App\Repositories\Imp\CategoryRepositoryImp;
use App\Repositories\Imp\ProductRepositoryImp;
use App\Repositories\Imp\SliderRepositoryImp;
use App\Repositories\Interfaces\ICategoryRepository;
use App\Repositories\Interfaces\IProductRepository;
use App\Repositories\Interfaces\ISliderRepository;
use App\services\Sharing\SharingService;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\View;

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

        /**
         * Dependency Injection product
         */
        $this->app->singleton(
            IProductRepository::class,
            ProductRepositoryImp::class
        );
        /**
         * Dependency Injection Slider
         */
        $this->app->singleton(
            ISliderRepository::class,
            SliderRepositoryImp::class
        );
        /**
         * Dependency Injection Category
         */
        $this->app->singleton(
            ICategoryRepository::class,
            CategoryRepositoryImp::class
        );

        /**
         * Dependency Injection Share Data To Global Project
         */
        $this->app->singleton('shared', function () {
            $sharingService = new SharingService();
            $categories = $this->app->make(ICategoryRepository::class)->getAll();
            $sharingService->share('categories', $categories);
            return $sharingService;
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
    }
}
