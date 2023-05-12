<?php

namespace App\Services\package;

abstract class BaseCartPackage implements IBaseCartPackage
{
    protected $instance;

    public function __construct()
    {
        $this->setInstance();
    }

    public abstract function getInstance();

    public function setInstance()
    {
        $this->instance = $this->getInstance();
    }

    public function addToCart($data)
    {
        $this->instance->add($data);
        return $this->instance->content();
    }

    public function getCarts(): array
    {
        return [
            'data' => $this->instance->content(),
            'total' => $this->total(),
            'count' => $this->count()
        ];
    }

    public function destroy(): void
    {
        $this->instance->destroy();
    }

    public function getCartByID($id)
    {
        return $this->instance->get($id);
    }

    public function total(): int
    {
        $result = 0;
        $carts = $this->instance->content();
        foreach ($carts as $item) $result += $item->qty * $item->price;
        return $result;
    }

    public function count(): int
    {
        return $this->instance->count();
    }
}
