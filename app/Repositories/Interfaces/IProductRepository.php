<?php

namespace App\Repositories\Interfaces;

use App\Models\Product;

interface IProductRepository extends IBaseRepository
{
    public function getItemByCate($data = array());

    public function getAllByCateID($data);

    public function searchByName($name);

    public function getItemBySlug($slug);

    public function getItemsRelated($cateId);

    public function orderByStatus($type = 'desc');

    public function updateStatus($ids, $option);

    public function addImagesToProduct(Product $product, array $data);

    public function addColorsToProduct(Product $product, array $data);

    public function addTagsToProduct(Product $product, array $data);
}
