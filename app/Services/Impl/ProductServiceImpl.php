<?php

namespace App\Services\Impl;

use App\Models\Product;
use Illuminate\Support\Str;
use App\Traits\StorageImageTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Services\Abstracts\BaseService;
use App\Services\Interfaces\IProductService;

class ProductServiceImpl extends BaseService implements IProductService
{
    use StorageImageTrait;

    public function getModel(): string
    {
        return Product::class;
    }

    public function addProduct(object $dataRequest)
    {
        $imagePathUploaded = "";
        try {
            DB::beginTransaction();
            $dataImageUpload = $this->storageUploadImage($dataRequest->feature_image_path, 'products');
            $imagePathUploaded = $dataImageUpload['file_path'];
            $product = $this->model->create([
                'name' => $dataRequest->name,
                'price' => $dataRequest->price,
                'feature_image_name' => $dataImageUpload['file_name'],
                'feature_image_path' => $dataImageUpload['file_path'],
                'content' => $dataRequest->contents,
                'slug' => Str::slug($dataRequest->name, '-'),
                'user_id' => Auth::id(),
                'category_id' => $dataRequest->category_id,
                'status' => $dataRequest->status,
                'short_desc' => $dataRequest->short_desc
            ]);
            DB::commit();
            return $product;
        } catch (\Exception $exception) {
            $this->removeFileUpload($imagePathUploaded);
            DB::rollBack();
            Log::error('message: ' . $exception->getMessage() . ' Line: ' . $exception->getLine());
        }
    }

    public function updateProductById($id, object $dataRequest): object
    {
        try {
            DB::beginTransaction();
            $product = $this->model->find($id);
            $imageProperty = ['file_name' => $product->feature_image_name, 'file_path' => $product->feature_image_path];
            if (isset($dataRequest->feature_image_path) || !empty($dataRequest->feature_image_path)) {
                $this->removeFileUpload($product->feature_image_path);
                $imageProperty = $this->storageUploadImage($dataRequest->feature_image_path, 'products');
            }
            $this->model->find($id)->update([
                'name' => $dataRequest->name,
                'price' => $dataRequest->price,
                'feature_image_name' => $imageProperty['file_name'],
                'feature_image_path' => $imageProperty['file_path'],
                'content' => $dataRequest->contents,
                'slug' => Str::slug($dataRequest->name, '-'),
                'user_id' => Auth::id(),
                'category_id' => $dataRequest->category_id,
                'status' => $dataRequest->status,
                'short_desc' => $dataRequest->short_desc
            ]);
            DB::commit();
            return $this->model->find($id);
        } catch (\Exception $exception) {
            DB::rollback();
            Log::error('message: ' . $exception->getMessage() . ' Line: ' . $exception->getLine());
        }
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

    public function orderByStatus($type = 'desc')
    {
        return $this->model->orderBy('status', $type)->get();
    }

    public function updateStatus($ids, $option)
    {
        return $this->model->whereIn('id', $ids)->update(['status' => $option]);
    }

    public function addImagesToProduct(Product $product, array $data)
    {
        return $product->images()->createMany($data);
    }

    public function addColorsToProduct(Product $product, array $id)
    {
        return $product->colors()->attach($id);
    }

    public function addTagsToProduct(Product $product, array $id)
    {
        return $product->tags()->attach($id);
    }

    public function updateTagsToProduct(Product $product, array $id)
    {
        return $product->tags()->sync($id);
    }

    public function updateColorsToProduct(Product $product, array $id)
    {
        return $product->colors()->sync($id);
    }

}
