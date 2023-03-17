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
}
