<?php

namespace App\Mappers;

use App\Dtos\Cart\CartDTO;
use App\Dtos\CartItem\CartItemDto;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Customer;

class CartMapper
{
    public static function toCartItemDTO(CartItem $cartItem): CartItemDto
    {
        $cartItemDTO = new CartItemDto();
        $product = $cartItem->product;
        $colors = $product->colors->map(function ($item) use ($cartItem) {
            return (object)['id' => $item->id, 'name' => $item->name, 'selected' => $item->id === $cartItem->color_id];
        });
        $cartItemDTO->setId($cartItem->id);
        $cartItemDTO->setName($product->name);
        $cartItemDTO->setImage($product->feature_image_path);
        $cartItemDTO->setQty($cartItem->qty);
        $cartItemDTO->setPrice($product->price);
        $cartItemDTO->setOption(['colors' => $colors, 'total' => $cartItem->qty * $product->price]);
        return $cartItemDTO;
    }

    public static function toCart(Customer $customer, int $total, array $cartItems): CartDTO
    {
        return new CartDTO($customer, $total, $cartItems);
    }
}
