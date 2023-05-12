<?php

namespace App\Dtos\cart;

use App\Dtos\AbstractDTO;
use App\Models\Product;

class CartDto extends AbstractDTO
{
    private int $total;
    private Product $product;

}
