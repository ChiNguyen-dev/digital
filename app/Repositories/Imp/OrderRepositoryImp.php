<?php

namespace App\Repositories\Imp;


use App\Models\Order;
use App\Repositories\Abstracts\BaseRepository;
use App\Repositories\Interfaces\IOrderRepository;

class OrderRepositoryImp extends BaseRepository implements IOrderRepository
{
    public function getModel()
    {
        return Order::class;
    }

    public function orderByStatus($type = 'desc')
    {
        return $this->model->with('customer')->orderBy('status', $type)->get();
    }

    public function updateMany(string $column, array $ids, array $data)
    {
        $this->model->whereIn($column, $ids)->update($data);
    }

    public function deleteMany(string $column, array $ids)
    {
        $this->model->whereIn($column, $ids)->delete();
    }
}
