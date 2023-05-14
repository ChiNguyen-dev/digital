<?php

namespace App\Services\Interfaces;

use App\Models\Product;
use App\Services\Interfaces\IBaseService;
use Illuminate\Database\Eloquent\Collection;

interface IProductService extends IBaseService
{
    public function addProduct(object $dataRequest);

    public function addImagesToProduct(Product $product, array $data);

    public function addColorsToProduct(Product $product, array $id);

    public function addTagsToProduct(Product $product, array $id);

    public function updateProductById($id, object $dataRequest);

    public function updateTagsToProduct(Product $product, array $id);

    public function updateColorsToProduct(Product $product, array $id);

    public function getItemByCate($data = array());

    public function getAllByCateID($data);

    public function searchByName($name);

    public function getItemBySlug($slug);

    public function getItemsRelated($cateId);

    public function orderByStatus($type = 'desc');

    public function updateStatus($ids, $option);

    public function getProductByIds(array $ids);
}
