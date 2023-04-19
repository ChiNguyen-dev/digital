<?php

namespace App\Services\Impl;

use App\Models\Customer;
use App\Services\Abstracts\BaseService;
use App\Services\Interfaces\ICustomerService;

class CustomerServiceImpl extends BaseService implements ICustomerService
{
    public function getModel()
    {
        return Customer::class;
    }

    public function findByEmail(String $email)
    {
        return $this->model->where('email', $email)->first();
    }
}
