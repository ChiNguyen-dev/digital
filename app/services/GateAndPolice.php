<?php

namespace App\services;

use App\Policies\CategoryPolicy;
use App\Policies\ColorPolicy;
use App\Policies\CustomerPolicy;
use App\Policies\OrderPolicy;
use App\Policies\ProductPolicy;
use App\Policies\RolePolicy;
use App\Policies\SliderPolicy;
use Illuminate\Support\Facades\Gate;

class GateAndPolice
{
    public function __construct()
    {
        $this->callGateAndPolice();
    }

    public function callGateAndPolice()
    {
        $this->defineGateAndPolicyRole();
        $this->defineGateAndPolicyCategory();
        $this->defineGateAndPolicyColor();
        $this->defineGateAndPolicyProduct();
        $this->defineGateAndPolicySlider();
        $this->defineGateAndPolicyOrder();
        $this->defineGateAndPolicyCustomer();
    }

    public function defineGateAndPolicyRole(): void
    {
        Gate::define(config('permissions.guards.isAdmin'), [RolePolicy::class, 'checkRoleAdmin']);
    }

    public function defineGateAndPolicyCategory(): void
    {
        Gate::define(config('permissions.modules.categories.show'), [CategoryPolicy::class, 'viewAny']);
        Gate::define(config('permissions.modules.categories.add'), [CategoryPolicy::class, 'create']);
        Gate::define(config('permissions.modules.categories.edit'), [CategoryPolicy::class, 'update']);
        Gate::define(config('permissions.modules.categories.delete'), [CategoryPolicy::class, 'delete']);
    }

    public function defineGateAndPolicyColor(): void
    {
        Gate::define(config('permissions.modules.colors.show'), [ColorPolicy::class, 'viewAny']);
        Gate::define(config('permissions.modules.colors.add'), [ColorPolicy::class, 'create']);
        Gate::define(config('permissions.modules.colors.edit'), [ColorPolicy::class, 'update']);
        Gate::define(config('permissions.modules.colors.delete'), [ColorPolicy::class, 'delete']);
    }

    public function defineGateAndPolicyProduct(): void
    {
        Gate::define(config('permissions.modules.products.show'), [ProductPolicy::class, 'viewAny']);
        Gate::define(config('permissions.modules.products.add'), [ProductPolicy::class, 'create']);
        Gate::define(config('permissions.modules.products.edit'), [ProductPolicy::class, 'update']);
        Gate::define(config('permissions.modules.products.delete'), [ProductPolicy::class, 'delete']);
        Gate::define(config('permissions.guards.isPermissionEdit'), [ProductPolicy::class, 'checkPermissionEdit']);
        Gate::define(config('permissions.guards.isPermissionDelete'), [ProductPolicy::class, 'checkPermissionDelete']);
    }

    public function defineGateAndPolicySlider(): void
    {
        Gate::define(config('permissions.modules.sliders.show'), [SliderPolicy::class, 'viewAny']);
        Gate::define(config('permissions.modules.sliders.add'), [SliderPolicy::class, 'create']);
        Gate::define(config('permissions.modules.sliders.edit'), [SliderPolicy::class, 'update']);
        Gate::define(config('permissions.modules.sliders.delete'), [SliderPolicy::class, 'delete']);
    }

    public function defineGateAndPolicyOrder(): void
    {
        Gate::define(config('permissions.modules.orders.show'), [OrderPolicy::class, 'viewAny']);
        Gate::define(config('permissions.modules.orders.update'), [OrderPolicy::class, 'update']);
    }

    public function defineGateAndPolicyCustomer(): void
    {
        Gate::define(config('permissions.modules.customers.show'), [CustomerPolicy::class, 'viewAny']);
        Gate::define(config('permissions.modules.customers.delete'), [CustomerPolicy::class, 'delete']);
    }

}
