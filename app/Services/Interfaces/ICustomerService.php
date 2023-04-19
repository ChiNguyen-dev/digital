<?php

namespace App\Services\Interfaces;

use App\Services\Interfaces\IBaseService;

interface ICustomerService extends IBaseService
{
    public function findByEmail(String $email);
}
