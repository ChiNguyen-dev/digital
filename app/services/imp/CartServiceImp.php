<?php

namespace App\services\imp;

use App\Models\Cart;
use App\Models\CartItem;
use App\services\ICartService;

class CartServiceImp implements ICartService
{

    private $cart;
    private $cartItem;

    public function __construct()
    {
        $this->cart = app(Cart::class);
        $this->cart = app(CartItem::class);
    }

    public function add($data)
    {

    }

    public function getCarts()
    {
        // TODO: Implement getCarts() method.
    }

    public function getCart()
    {
        // TODO: Implement getCart() method.
    }
}
