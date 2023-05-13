<?php

namespace App\Mappers;

use App\Dtos\cart\CartItemDto;
use App\Models\CartItem;

class CartMapper
{
    public static function toCartItemDTO(CartItem $cartItem): CartItemDto
    {
        $cartItemDTO = new CartItemDto();
        $product = $cartItem->product;
        $colors = $product->colors->map(function ($item, $key) use ($cartItem) {
            return (object)['id' => $item->id, 'name' => $item->name, 'selected' => $item->id === $cartItem->color_id];
        });
        $cartItemDTO->setId($cartItem->id);
        $cartItemDTO->setName($product->name);
        $cartItemDTO->setImage($product->feature_image_path);
        $cartItemDTO->setQty($cartItem->qty);
        $cartItemDTO->setPrice($product->price);
        $cartItemDTO->setOption(['colors' => $colors,'total' => $cartItem->qty * $product->price]);
        return $cartItemDTO;
    }
}
