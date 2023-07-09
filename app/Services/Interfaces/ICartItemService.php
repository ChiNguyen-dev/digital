<?php

namespace App\Services\Interfaces;

use App\Dtos\cartItem\CartItemFormDTO;
use App\Models\Customer;

interface ICartItemService extends IBaseService
{
    public function addToCartItem(CartItemFormDTO $cartItemFormDTO);

    public function getTotalAmountItem(Customer $customer);


}
