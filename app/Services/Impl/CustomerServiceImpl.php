<?php

namespace App\Services\Impl;

use App\Models\Customer;
use App\Services\Abstracts\BaseService;
use App\Services\Interfaces\ICustomerService;

class CustomerServiceImpl extends BaseService implements ICustomerService
{
    public function getModel(): string
    {
        return Customer::class;
    }

    public function findByEmail(string $email)
    {
        return $this->model->where('email', $email)->first();
    }

    public function search($column, $condition)
    {
        return $this->model->where($column, 'LIKE', "%{$condition}%")->take(5)->get();
    }


}
