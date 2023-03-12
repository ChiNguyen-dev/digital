<?php

namespace App\services;

use Gloudemans\Shoppingcart\Facades\Cart;

class CartService
{
    private $obj;

    public function __construct()
    {
        $this->obj = Cart::instance('shopping');
    }

    public function add($data)
    {
        $this->obj->add($data);
        return $this->content();
    }
    public function destroy(): void
    {
        $this->obj->destroy();
    }

    public function content()
    {
        return $this->obj->content();
    }

    public function total(): int
    {
        $result = 0;
        foreach ($this->content() as $value) $result += $value->qty * $value->price;
        return $result;
    }

    public function count()
    {
        return $this->obj->count();
    }

    public function updateQtyById($id, $qty): void
    {
        $this->obj->update($id, $qty);
    }

    public function updateColorById($id, $data)
    {
        $this->obj->update($id, $data);
        return $this->content();
    }

    public function removeItemById($id): void
    {
        $this->obj->remove($id);
    }

    public function findItemByid($id)
    {
        return $this->obj->get($id);
    }

    /**
     * @return mixed
     */
    public function getObj()
    {
        return $this->obj;
    }

    /**
     * @param mixed $obj
     */
    public function setObj($obj): void
    {
        $this->obj = $obj;
    }

}
