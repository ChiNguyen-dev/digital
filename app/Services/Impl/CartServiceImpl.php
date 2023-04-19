<?php

namespace App\Services\Impl;

use Gloudemans\Shoppingcart\Facades\Cart;
use App\Services\Interfaces\ICartService;
use App\Services\Abstracts\BaseCartService;

class CartServiceImpl extends BaseCartService implements ICartService
{

    public function getInstance()
    {
        return Cart::instance('shopping');
    }

    public function updateQtyById($id, $qty): void
    {
        $this->instance->update($id, $qty);
    }

    public function removeItemById($id): void
    {
        $this->instance->remove($id);
    }

    public function updateColorById($id, $data)
    {
        $this->instance->update($id, $data);
        return $this->instance->content();
    }
}
