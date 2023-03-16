<?php

namespace App\Repositories\Imp;

use App\Models\Product;
use App\Repositories\Abstracts\BaseRepository;
use App\Repositories\Interfaces\IProductRepository;

class ProductRepositoryImp extends BaseRepository implements IProductRepository
{
    public function getModel(): string
    {
        return Product::class;
    }

    public function getItemByCate($data = array())
    {
        $data = $this->model->where('status', 1)->whereIn('category_id', $data)->latest()->take(8)->get();
        return !$data->isEmpty() ? $data : null;
    }

    public function getAllByCateID($data)
    {
        $data = $this->model->where('status', 1)->whereIn('category_id', $data)->latest()->get();
        return !$data->isEmpty() ? $data : null;
    }

    public function searchByName($name)
    {
        $data = $this->model->where('name', 'LIKE', "%{$name}%")->take(3)->get();
        if (!empty($data)) {
            $data->map(function ($item) {
                $item->feature_image_path = asset($item->feature_image_path);
            });
        }
        return !$data->isEmpty() ? $data : null;
    }

    public function getItemBySlug($slug)
    {
        $data = $this->model->where('slug', $slug)->first();
        return !empty($data) ? $data : null;
    }

    public function getItemsRelated($cateId)
    {
        $data = $this->model->where('status', 1)
                            ->where('category_id', $cateId)
                            ->take(2)
                            ->get();
        return !empty($data) ? $data : null;
    }
}
