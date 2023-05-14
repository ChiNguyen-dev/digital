<?php

namespace App\Services\Impl;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Customer;
use App\Models\Product;
use App\Services\Abstracts\BaseService;
use App\Services\Interfaces\ICartItemService;

class CartItemServiceImpl extends BaseService implements ICartItemService
{
    public function getModel(): string
    {
        return CartItem::class;
    }

    public function addCartItem(Cart $cart, Product $product, array $option)
    {
        $data = ['cart_id' => $cart->id, 'product_id' => $product->id, 'color_id' => $option['color']];
        $cartItem = $this->model->where('cart_id', $cart->id)
            ->where('product_id', $product->id)
            ->where('color_id', $option['color'])->first();
        if (empty($cartItem)) {
            $this->model->create(array_merge($data, ['qty' => 1]));
        } else {
            $cartItem->update(array_merge($option, ['qty' => $cartItem->qty + 1]));
        }
        $totalAmount = $this->model->where('cart_id', $cart->id)->sum('qty');
        session(['qty' => $totalAmount]);
    }

    public function getTotalAmountItem(Customer $customer): int
    {
        $totalAmount = 0;
        $cartByUser = $customer->cart;
        if (!empty($cartByUser)) {
            $totalAmount = $this->model->where('cart_id', $cartByUser->id)->sum('qty');
        }
        return $totalAmount;
    }
}
