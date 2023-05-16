<?php

namespace App\Services\Interfaces;

use App\Dtos\CartItem\CartItemFormDTO;
use App\Models\Customer;

interface ICartItemService extends IBaseService
{
    public function addToCartItem(CartItemFormDTO $cartItemFormDTO);

    public function getTotalAmountItem(Customer $customer);


}
