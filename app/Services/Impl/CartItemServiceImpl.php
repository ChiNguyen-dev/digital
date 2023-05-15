<?php

namespace App\Services\Impl;

use App\Dtos\cart\CartItemFormDTO;
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

    public function getTotalAmountItem(Customer $customer): int
    {
        $totalAmount = 0;
        $cartByUser = $customer->cart;
        if (!empty($cartByUser)) {
            $totalAmount = $this->model->where('cart_id', $cartByUser->id)->sum('qty');
        }
        return $totalAmount;
    }
    public function addToCartItem(CartItemFormDTO $cartItemFormDTO)
    {
        $condition = [
            'cart_id' => $cartItemFormDTO->getCartId(),
            'product_id' => $cartItemFormDTO->getProductId(),
            'color_id' => $cartItemFormDTO->getColorId()
        ];
        $cartItem = $this->model->where('cart_id', $cartItemFormDTO->getCartId())
            ->where('product_id', $cartItemFormDTO->getProductId())
            ->where('color_id', $cartItemFormDTO->getColorId())->first();
        $quantity = empty($cartItem) ? $cartItemFormDTO->getQty() : $cartItem->qty + $cartItemFormDTO->getQty();
        $this->model->updateOrCreate(
            $condition,
            array_merge($condition, ['qty' => $quantity])
        );
        $totalAmount = $this->model->where('cart_id', $cartItemFormDTO->getCartId())->sum('qty');
        session(['qty' => $totalAmount]);
    }
}
