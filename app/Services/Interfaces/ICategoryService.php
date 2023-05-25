<?php

namespace App\Services\Interfaces;
interface ICategoryService extends IBaseService
{
//    public function findMultipleBySlug(...$data);

    public function findBySlug($slug);

}
