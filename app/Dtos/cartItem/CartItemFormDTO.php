<?php

namespace App\Dtos\cartItem;

class CartItemFormDTO
{
    private int $cartId;
    private int $productId;
    private int $colorId;
    private int $qty;

    /**
     * @param int $cartId
     * @param int $productId
     * @param int $colorId
     * @param int $qty
     */
    public function __construct(int $cartId, int $productId, int $colorId, int $qty)
    {
        $this->cartId = $cartId;
        $this->productId = $productId;
        $this->colorId = $colorId;
        $this->qty = $qty;
    }

    /**
     * @return int
     */
    public function getCartId(): int
    {
        return $this->cartId;
    }

    /**
     * @param int $cartId
     */
    public function setCartId(int $cartId): void
    {
        $this->cartId = $cartId;
    }

    /**
     * @return int
     */
    public function getProductId(): int
    {
        return $this->productId;
    }

    /**
     * @param int $productId
     */
    public function setProductId(int $productId): void
    {
        $this->productId = $productId;
    }

    /**
     * @return int
     */
    public function getColorId(): int
    {
        return $this->colorId;
    }

    /**
     * @param int $colorId
     */
    public function setColorId(int $colorId): void
    {
        $this->colorId = $colorId;
    }

    /**
     * @return int
     */
    public function getQty(): int
    {
        return $this->qty;
    }

    /**
     * @param int $qty
     */
    public function setQty(int $qty): void
    {
        $this->qty = $qty;
    }

}
