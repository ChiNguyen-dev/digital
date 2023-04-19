<?php

namespace App\Services\Interfaces;

use App\Services\Interfaces\IBaseService;

interface ICategoryService extends IBaseService
{
    public function findMultipleBySlug(...$data);

    public function findBySlug($slug);

}
