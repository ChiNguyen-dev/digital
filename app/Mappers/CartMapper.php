<?php

namespace App\Mappers;

use App\Dtos\Cart\CartDTO;
use App\Dtos\CartItem\CartItemDto;
use App\Models\CartItem;
use App\Models\Customer;

class CartMapper
{
    public static function toCartItemDTO(CartItem $cartItem): CartItemDto
    {
        $product = $cartItem->product;
        $colors = $product->colors->map(function ($item) use ($cartItem) {
            return (object)[
                'id' => $item->id,
                'name' => $item->name,
                'style' => $item->style,
                'selected' => $item->id == $cartItem->color_id];
        });
        return new CartItemDto(
            $cartItem->id,
            $product->name,
            $product->feature_image_path,
            $product->price, $cartItem->qty,
            ['colors' => $colors, 'total' => $cartItem->qty * $product->price]
        );
    }

    public static function toCart(Customer $customer, int $total, array $cartItems): CartDTO
    {
        return new CartDTO($customer, $total, $cartItems);
    }
}
