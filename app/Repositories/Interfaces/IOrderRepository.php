<?php

namespace App\Repositories\Interfaces;

interface IOrderRepository extends IBaseRepository
{
    public function orderByStatus($type = 'desc');

    public function updateMany(string $column, array $ids, array $data);

    public function deleteMany(string $column, array $ids);
}
