<?php

namespace App\Builders\cartItem;

use App\Dtos\cartItem\CartItemDto;

class CartItemBuilder implements ICartItemBuilder
{
    protected int $id;
    protected string $name;
    protected string $image;
    protected string $price;
    protected int $qty;
    protected array $option;

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    function productName(string $name): CartItemBuilder
    {
        $this->name = $name;
        return $this;
    }

    function productImage(string $image): CartItemBuilder
    {
        $this->image = $image;
        return $this;
    }

    function productPrice(string $price): CartItemBuilder
    {
        $this->price = $price;
        return $this;
    }

    function productQuantity(int $qty): CartItemBuilder
    {
        $this->qty = $qty;
        return $this;
    }

    function option(array $options): CartItemBuilder
    {
        $this->option = $options;
        return $this;
    }

    function build(): CartItemDto
    {
        return new CartItemDto(
            $this->id,
            $this->name,
            $this->image,
            $this->price,
            $this->qty,
            $this->option
        );
    }
}
