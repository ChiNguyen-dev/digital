<?php

namespace App\Services\Interfaces;

use App\Services\Interfaces\IBaseService;


interface IOrderService extends IBaseService
{
    public function orderByStatus($type = 'desc');

    public function updateMany(string $column, array $ids, array $data);
}
