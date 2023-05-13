<?php

namespace App\Services\Interfaces;

use App\Services\package\ICartPackage;

interface ICartService extends IBaseService
{
    public function addCart(ICartPackage $cartPackage, ICartItemService $cartItemService);

    public function getCartsByUserId(int $id);

    public function destroy(int $userId);

}
