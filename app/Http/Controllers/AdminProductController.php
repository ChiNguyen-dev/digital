<?php

namespace App\Http\Controllers;

use App\Helpers\CategoryRecursive;
use App\Http\Requests\ProductAddRequest;
use App\Models\Category;
use App\Models\Color;
use App\Models\ProductImage;
use App\Models\Tag;
use App\Repositories\Interfaces\IProductRepository;
use App\Traits\StorageImageTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class AdminProductController extends Controller
{
    use StorageImageTrait;

    private $category;
    private $productRepo;
    private $tag;
    private $productImage;
    private $color;
    private $categoryRecursive;
    private $numberOfPage = 15;

    public function __construct(
        Category          $category,
        IProductRepository           $iProductRepository,
        Tag               $tag,
        ProductImage      $productImage,
        Color             $color,
        CategoryRecursive $categoryRecursive
    ) {
        $this->category = $category;
        $this->productRepo = $iProductRepository;
        $this->tag = $tag;
        $this->productImage = $productImage;
        $this->color = $color;
        $this->categoryRecursive = $categoryRecursive;
    }

    public function index(Request $request)
    {
        $data = $this->productRepo->orderByStatus('ASC');
        $status = (object)[
            'success' =>  $data->where('status', 1)->count(),
            'processing' => $data->where('status', 0)->count(),
            'quantity' => $data->count(),
            'deleted' => $this->productRepo->countSoftDelete(),
        ];
        $products = $request->has('search') ?
            $this->productRepo->search('name', $request->search) :
            $products = $this->productRepo->pagination($data, 15);
        $products->load('category');
        return view('admin.products.index', compact('products', 'status'));
    }

    public function create()
    {
        $htmlOption = $this->categoryRecursive->categoryRecursive();
        $colors = $this->color->all();
        return view('admin.products.add', compact('htmlOption', 'colors'));
    }

    public function store(ProductAddRequest $request)
    {
        try {
            DB::beginTransaction();

            $dataInsertProduct = $this->getDataProduct($request);
            $dataImageUpload = $this->storageUploadImage($request->feature_image_path, 'products');
            $dataInsertProduct['feature_image_name'] = $dataImageUpload['file_name'];
            $dataInsertProduct['feature_image_path'] = $dataImageUpload['file_path'];
            $insertedProduct = $this->productRepo->create($dataInsertProduct);
            if (!empty($request->image_path)) {
                foreach ($request->image_path as $file) {
                    $dataImageUploadMultiple = $this->storageUploadImage($file, 'products');
                    $insertedProduct->images()->create([
                        'image_path' => $dataImageUploadMultiple['file_path'],
                        'image_name' => $dataImageUploadMultiple['file_name'],
                    ]);
                }
            }
            $tagIds = [];
            foreach ($request->tags as $tag) {
                $dataTag = $this->tag->firstOrCreate(['name' => $tag]);
                $tagIds[] = $dataTag->id;
            }
            $insertedProduct->tags()->attach($tagIds);
            if ($request->has('colors')) {
                $insertedProduct->colors()->attach($request->colors);
            }
            DB::commit();
            return redirect()->route('product.index');
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('message: ' . $exception->getMessage() . ' Line: ' . $exception->getLine());
        }
    }

    public function edit($id)
    {
        $product = $this->productRepo->find($id);
        if (!$this->authorize(config('permissions.modules.products.edit'), $product)) abort(403);
        $htmlOption = $this->categoryRecursive->categoryRecursive($product->category_id);
        $colors = $this->color->all();
        return view('admin.products.edit', compact('product', 'htmlOption', 'colors'));
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $product = $this->productRepo->find($id);

            $dataUpdateProduct = $this->getDataProduct($request);

            if ($request->hasFile('feature_image_path')) {
                if (File::exists(public_path($product->feature_image_path))) {
                    File::delete(public_path($product->feature_image_path));
                }
                $dataImageUpload = $this->storageUploadImage($request->feature_image_path, 'products');
                $dataUpdateProduct['feature_image_name'] = $dataImageUpload['file_name'];
                $dataUpdateProduct['feature_image_path'] = $dataImageUpload['file_path'];
            }

            $product->update($dataUpdateProduct);

            if ($request->hasFile('image_path')) {
                $product_images = $this->productImage->where('product_id', $id)->get();
                foreach ($product_images as $product_image) {
                    if (File::exists(public_path($product_image->image_path))) {
                        File::delete(public_path($product_image->image_path));
                    }
                    $this->productImage->find($product_image->id)->delete();
                }
                foreach ($request->image_path as $file) {
                    $dataImageUploadMultiple = $this->storageUploadImage($file, 'products');
                    $product->images()->create([
                        'image_path' => $dataImageUploadMultiple['file_path'],
                        'image_name' => $dataImageUploadMultiple['file_name'],
                    ]);
                }
            }
            if ($request->has('tags')) {
                $tagIds = [];
                foreach ($request->tags as $tag) {
                    $dataTag = $this->tag->firstOrCreate(['name' => $tag]);
                    $tagIds[] = $dataTag->id;
                }
                $product->tags()->sync($tagIds);
            }
            if ($request->has('colors')) $product->colors()->sync($request->colors);

            DB::commit();
            return redirect()->route('product.index');
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('message: ' . $exception->getMessage() . ' Line: ' . $exception->getLine());
        }
    }

    public function delete($id): JsonResponse
    {
        try {
            $product = $this->productRepo->delete($id);
            $quantity = $this->productRepo->countSoftDelete();
            return response()->json(['code' => 200, 'message' => 'Delete Success!', 'quantityDeleted' => $quantity], 200);
        } catch (\Exception $exception) {
            Log::error('message: ' . $exception->getMessage() . ' Line: ' . $exception->getLine());
            return response()->json(['code' => 500, 'message' => 'Delete fail'], 500);
        }
    }
    public function getDataProduct(Request $request): array
    {
        return [
            'name' => $request->name,
            'price' => $request->price,
            'content' => $request->contents,
            'slug' => Str::slug($request->name, '-'),
            'user_id' => Auth::id(),
            'category_id' => $request->category_id,
            'status' => $request->status,
            'short_desc' => $request->short_desc
        ];
    }

    public function updateAll(Request $request): RedirectResponse
    {
        if ($request->option != null) {
            if ($request->has('check'))
                $this->productRepo->updateStatus($request->check, $request->option);
        }
        return redirect()->route('product.index');
    }
}
