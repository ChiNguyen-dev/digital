<?php

namespace App\services;

interface ICartService
{
    public function add($data);

    public function getCarts();

    public function getCart();
}
