<?php

namespace App\Services\Impl;

use App\Models\CartItem;
use App\Services\Abstracts\BaseService;
use App\Services\Interfaces\ICartItemService;

class CartItemServiceImpl extends BaseService implements ICartItemService
{
    public function getModel(): string
    {
        return CartItem::class;
    }
}
