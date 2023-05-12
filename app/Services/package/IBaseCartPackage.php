<?php

namespace App\Services\package;

interface IBaseCartPackage
{
    public function addToCart($data);

    public function getCarts(): array;

    public function getCartByID($id);

    public function destroy(): void;

    public function total(): int;

    public function count(): int;
}
