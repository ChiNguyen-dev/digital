<?php

namespace App\Repositories\Interfaces;

interface IProductRepository extends IBaseRepository
{
    public function getItemByCate($data = array());

    public function getAllByCateID($data);

    public function searchByName($name);

    public function getItemBySlug($slug);

    public function getItemsRelated($cateId);

    public function orderByStatus($type = 'desc');

    public function updateStatus($ids, $option);
}
