<?php

namespace App\Mappers;

use App\Builders\cartItem\CartItemBuilder;
use App\Dtos\cart\CartDTO;
use App\Dtos\cartItem\CartItemDto;
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
        return (new CartItemBuilder($cartItem->id))
            ->productName($product->name)
            ->productImage($product->feature_image_path)
            ->productPrice($product->price)
            ->productQuantity($cartItem->qty)
            ->option(['colors' => $colors, 'total' => $cartItem->qty * $product->price])
            ->build();
    }

    public static function toCart(Customer $customer, int $total, array $cartItems): CartDTO
    {
        return new CartDTO($customer, $total, $cartItems);
    }
}
