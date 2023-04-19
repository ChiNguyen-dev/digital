<?php

namespace App\Services\Impl;

use App\Models\ProductImage;
use App\Services\Abstracts\BaseService;
use App\Services\Interfaces\IProductImageService;

class ProductImageServiceImpl extends BaseService implements IProductImageService
{
    public  function getModel()
    {
        return ProductImage::class;
    }
}
