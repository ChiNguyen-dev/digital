<?php

namespace App\Services\Interfaces;

use App\Models\Cart;

interface ICartItemService extends IBaseService
{
    public function addCartItem(Cart $cart, $attributes);
}
