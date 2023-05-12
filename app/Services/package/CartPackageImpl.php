<?php

namespace App\Services\package;

use Gloudemans\Shoppingcart\Facades\Cart;

class CartPackageImpl extends BaseCartPackage implements ICartPackage
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
