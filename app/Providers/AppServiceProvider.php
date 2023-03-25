<?php

namespace App\Providers;

use App\services\ICartService;
use App\services\imp\CartServiceImp;
use Illuminate\Support\ServiceProvider;
use App\services\Sharing\SharingService;
use App\Repositories\Imp\RoleRepositoryImp;
use App\Repositories\Imp\UserRepositoryImp;
use App\Repositories\Imp\ColorRepositoryImp;
use App\Repositories\Imp\OrderRepositoryImp;
use App\Repositories\Imp\SliderRepositoryImp;
use App\services\imp\ProvinceDistrictWardImp;
use App\Repositories\Imp\ProductRepositoryImp;
use App\services\IProvinceDistrictWardService;
use App\Repositories\Imp\CategoryRepositoryImp;
use App\Repositories\Imp\CustomerRepositoryImp;
use App\Repositories\Interfaces\IRoleRepository;
use App\Repositories\Interfaces\IUserRepository;
use App\Repositories\Imp\PermissionRepositoryImp;
use App\Repositories\Interfaces\IColorRepository;
use App\Repositories\Interfaces\IOrderRepository;
use App\Repositories\Interfaces\ISliderRepository;
use App\Repositories\Interfaces\IProductRepository;
use App\Repositories\Interfaces\ICategoryRepository;
use App\Repositories\Interfaces\ICustomerRepository;
use App\Repositories\Interfaces\IPermissionRepository;

class AppServiceProvider extends ServiceProvider
{

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        /**
         * Dependency Injection product
         */
        $this->app->singleton(IProductRepository::class, ProductRepositoryImp::class);
        /**
         * Dependency Injection Slider
         */
        $this->app->singleton(ISliderRepository::class,  SliderRepositoryImp::class);
        /**
         * Dependency Injection Category
         */
        $this->app->singleton(ICategoryRepository::class,  CategoryRepositoryImp::class);

        /**
         * Dependency Injection Cart
         */
        $this->app->singleton(ICartService::class, CartServiceImp::class);

        /**
         * Dependency Injection Province and District and Ward
         */
        $this->app->singleton(IProvinceDistrictWardService::class, ProvinceDistrictWardImp::class);

        /**
         * Dependency Injection Customer
         */
        $this->app->singleton(ICustomerRepository::class, CustomerRepositoryImp::class);

        /**
         * Dependency Injection Order
         */
        $this->app->singleton(IOrderRepository::class, OrderRepositoryImp::class);

        /**
         * Dependency Injection User
         */
        $this->app->singleton(IUserRepository::class, UserRepositoryImp::class);

        /**
         * Dependency Injection Role
         */
        $this->app->singleton(IRoleRepository::class, RoleRepositoryImp::class);

        /**
         * Dependency Injection Color
         */
        $this->app->singleton(IColorRepository::class, ColorRepositoryImp::class);

        /**
         * Dependency Injection Permission
         */
        $this->app->singleton(IPermissionRepository::class, PermissionRepositoryImp::class);

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
