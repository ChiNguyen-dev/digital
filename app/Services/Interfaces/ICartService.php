<?php

namespace App\Services\Interfaces;

use App\Dtos\cart\CartDTO;
use App\Models\Customer;
use App\Models\Product;

interface ICartService extends IBaseService
{
    public function addToCart(ICartItemService $cartItemService, Product $product, array $options);

    public function getCartsByUser(Customer $customer): CartDTO;

    public function destroy(Customer $customer): void;

    public function updateTotal(Customer $customer): void;

    public function checkCartAfterAuthenticate(ICartItemService $cartItemService);

}
