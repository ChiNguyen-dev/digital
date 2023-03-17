<?php

namespace App\Repositories\Imp;

use App\Models\Customer;
use App\Repositories\Abstracts\BaseRepository;
use App\Repositories\Interfaces\ICustomerRepository;

class CustomerRepositoryImp extends BaseRepository implements ICustomerRepository
{
    public function getModel()
    {
        return Customer::class;
    }
}
