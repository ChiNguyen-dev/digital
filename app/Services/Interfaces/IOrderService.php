<?php

namespace App\Services\Interfaces;

interface IOrderService extends IBaseService
{
    public function orderByStatus($type = 'desc');
    public function findByCustomerIdContaining(array $ids);

    public function updateMany(string $column, array $ids, array $data);
}
