<?php

namespace App\Services\Impl;

use App\Models\Cart;
use App\Models\CartItem;
use App\Services\Abstracts\BaseService;
use App\Services\Interfaces\ICartItemService;

class CartItemServiceImpl extends BaseService implements ICartItemService
{
    public function getModel(): string
    {
        return CartItem::class;
    }

    public function addCartItem(Cart $cart, $attributes)
    {
        $attributes->map(function ($item) use ($cart) {
            $this->model->updateOrCreate(
                ['cart_id' => $cart->id, 'product_id' => $item->id, 'color_id' => $item->options['color'], 'qty' => $item->qty]
            );
        });
        $totalAmount = $this->model->where('cart_id', $cart->id)->sum('qty');
        session(['qty' => $totalAmount]);
    }
}
