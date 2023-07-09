<?php

namespace App\Builders\cartItem;

use App\Dtos\cartItem\CartItemDto;

interface ICartItemBuilder
{
    function productName(string $name): CartItemBuilder;

    function productImage(string $image): CartItemBuilder;

    function productPrice(string $price): CartItemBuilder;

    function productQuantity(int $qty): CartItemBuilder;

    function option(array $options): CartItemBuilder;

    function build(): CartItemDto;
}
