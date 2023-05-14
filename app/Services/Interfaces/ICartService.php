<?php

namespace App\Services\Interfaces;

use App\Models\Customer;

interface ICartService extends IBaseService
{
    public function addToCart(int $total = 0);

    public function getCartsByUser(Customer $customer);

    public function destroy(Customer $customer): void;

    public function updateTotal(Customer $customer): void;

}
