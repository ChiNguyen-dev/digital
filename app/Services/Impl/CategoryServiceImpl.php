<?php

namespace App\Services\Impl;

use App\Models\Category;
use App\Services\Abstracts\BaseService;
use App\Services\Interfaces\ICategoryService;

class CategoryServiceImpl extends BaseService implements ICategoryService
{
    public function getModel()
    {
        return Category::class;
    }

    public function findBySlug($slug)
    {
        return $this->model->where('slug', $slug)->first();
    }
}
