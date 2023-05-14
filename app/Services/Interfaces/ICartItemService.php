<?php

namespace App\Services\Interfaces;

use App\Models\Cart;
use App\Models\Customer;
use App\Models\Product;

interface ICartItemService extends IBaseService
{
    public function addCartItem(Cart $cart, Product $product, array $option);

    public function getTotalAmountItem(Customer $customer);
}
