<?php

namespace App\Services\package;

use App\Models\Product;

interface IBaseCartPackage
{
    public function addToCart(Product $product, array $options);

    public function getCarts(): array;

    public function getCartByID($id);

    public function destroy(): void;

    public function total(): int;

    public function count(): int;
}
