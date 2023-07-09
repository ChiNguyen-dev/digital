<?php

namespace App\Services\Interfaces;

interface ICustomerService extends IBaseService
{
    public function findByEmail(String $email);

}
