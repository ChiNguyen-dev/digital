<?php

namespace App\Services\Impl;

use App\Models\CustomerVariant;
use App\Services\Abstracts\BaseService;
use App\Services\Interfaces\ICustomerVariantService;

class CustomerVariantServiceImpl extends BaseService implements ICustomerVariantService
{
    public function getModel(): string
    {
        return CustomerVariant::class;
    }

    public function create($data)
    {
        return parent::firstOrCreate($data, $data);
    }
}
