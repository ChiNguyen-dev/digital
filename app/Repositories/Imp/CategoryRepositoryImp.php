<?php

namespace App\Repositories\Imp;

use App\Models\Category;
use App\Repositories\Abstracts\BaseRepository;
use App\Repositories\Interfaces\ICategoryRepository;

class CategoryRepositoryImp extends BaseRepository implements ICategoryRepository
{
    public function getModel()
    {
        return Category::class;
    }

    public function findMultipleBySlug(...$data)
    {
        $this->setColumn('id', 'cate_name', 'slug');
        return $this->model->whereIn('slug', $data)->get($this->getColumn());
    }

    public function findBySlug($slug)
    {
        return $this->model->where('slug', $slug)->first();
    }
}
