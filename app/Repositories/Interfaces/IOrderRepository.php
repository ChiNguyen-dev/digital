<?php

namespace App\Repositories\Interfaces;

interface IOrderRepository extends IBaseRepository
{
    public function orderByStatus($type = 'desc');
}
