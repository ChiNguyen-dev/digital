<?php

namespace App\services;

interface IBaseCartService
{
    public function addToCart($data);

    public function getCarts();

    public function getCartByID($id);

    public function destroy(): void;

    public function total(): int;

    public function count(): int;
  
}
