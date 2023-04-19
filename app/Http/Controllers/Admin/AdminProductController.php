<?php

namespace App\Http\Controllers\Admin;

use App\Models\ProductImage;
use App\Traits\StorageImageTrait;
use App\Helpers\CategoryRecursive;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductAddRequest;
use App\Services\Interfaces\IColorService;
use App\Services\Interfaces\IProductImageService;
use App\Services\Interfaces\IProductService;
use App\Services\Interfaces\ITagService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Illuminate\Http\RedirectResponse;


class AdminProductController extends Controller
{
    use StorageImageTrait;

    private IProductImageService $productImageService;
    private IProductService $productService;
    private IColorService $colorService;
    private CategoryRecursive $categoryRecursive;
    private ITagService $tagService;
    private $numberOfPage = 15;

    public function __construct(
        IProductService           $productService,
        IProductImageService      $productImageService,
        IColorService             $colorService,
        ITagService $tagService,
        CategoryRecursive $categoryRecursive
    ) {
        $this->productService = $productService;
        $this->productImageService = $productImageService;
        $this->colorService = $colorService;
        $this->categoryRecursive = $categoryRecursive;
        $this->tagService = $tagService;
        $this->middleware(function ($request, $next) {
            session([
                'active' => 'product',
            ]);
            return $next($request);
        });
    }

    /**
     * Undocumented function
     * Done
     * @param Request $request
     * @return void
     */
    public function index(Request $request)
    {
        $data = $this->productService->orderByStatus('ASC');
        $status = (object)[
            'success' =>  $data->where('status', 1)->count(),
            'processing' => $data->where('status', 0)->count(),
            'quantity' => $data->count(),
            'deleted' => $this->productService->countSoftDelete(),
        ];
        $products = $request->has('search') ?
            $this->productService->search('name', $request->search) :
            $this->productService->pagination($data, 15);
        $products->load('category');
        return view('admin.products.index', compact('products', 'status'));
    }

    /**
     * Undocumented function
     * Done
     * @return void
     */
    public function create()
    {
        $htmlOption = $this->categoryRecursive->categoryRecursive();
        $colors = $this->colorService->getAll();
        return view('admin.products.add', compact('htmlOption', 'colors'));
    }

    /**
     * Undocumented function
     * Done
     * @param ProductAddRequest $request
     * @return void
     */
    public function store(ProductAddRequest $request)
    {
        $images = array();
        try {
            DB::beginTransaction();

            $tags = $this->tagService->firstOrCreate($request->tags);

            $product = $this->productService->addProduct((object) $request->all());

            $this->productService->addTagsToProduct($product, $tags);

            $this->productService->addColorsToProduct($product, $request->colors);

            if (isset($request->image_path) || !empty($request->image_path)) {
                $images = $this->storageUploadMultipleImage($request->image_path, 'products');
                $this->productService->addImagesToProduct($product, $images);
            }
            DB::commit();
            return redirect()->route('product.index');
        } catch (\Exception $exception) {
            collect($images)->map(fn ($image) => $this->removeFileUpload($image['image_path']));
            DB::rollBack();
            Log::error('message: ' . $exception->getMessage() . ' Line: ' . $exception->getLine());
        }
    }
    /**
     * Undocumented function
     * Done
     * @param [type] $id
     * @return void
     */
    public function edit($id)
    {
        $product = $this->productService->find($id);
        if (!$this->authorize(config('permissions.modules.products.edit'), $product)) abort(403);
        $htmlOption = $this->categoryRecursive->categoryRecursive($product->category_id);
        $colors = $this->colorService->getAll();
        return view('admin.products.edit', compact('product', 'htmlOption', 'colors'));
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $product = $this->productService->updateProductById($id, (object) $request->all());
            
            if ($request->hasFile('image_path')) {
                $productImages = $this->productImageService->getAllByWhere('product_id', $id);

                $productImages->map(fn ($item) => $this->removeFileUpload($item->image_path));

                $this->productImageService->deleteMany($productImages->modelKeys());

                $images =  $this->storageUploadMultipleImage($request->image_path, 'products');

                $this->productService->addImagesToProduct($product, $images);
            }
            if ($request->has('tags')) {
                $tagIds = $this->tagService->firstOrCreate($request->tags);
                $this->productService->updateTagsToProduct($product, $tagIds);
            }
            if ($request->has('colors')) $this->productService->updateColorsToProduct($product, $request->colors);
            DB::commit();
            return redirect()->route('product.index');
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('message: ' . $exception->getMessage() . ' Line: ' . $exception->getLine());
        }
    }

    /**
     * Undocumented function
     * Done
     * @param [type] $id
     * @return JsonResponse
     */
    public function delete($id): JsonResponse
    {
        try {
            $product = $this->productService->delete($id);
            $quantity = $this->productService->countSoftDelete();
            return response()->json(['code' => 200, 'message' => 'Delete Success!', 'quantityDeleted' => $quantity], 200);
        } catch (\Exception $exception) {
            Log::error('message: ' . $exception->getMessage() . ' Line: ' . $exception->getLine());
            return response()->json(['code' => 500, 'message' => 'Delete fail'], 500);
        }
    }



    /**
     * Undocumented function
     * Done
     * @param Request $request
     * @return RedirectResponse
     */
    public function updateStatus(Request $request): RedirectResponse
    {
        if ($request->option != null) {
            if ($request->has('check'))
                $this->productService->updateStatus($request->check, $request->option);
        }
        return redirect()->route('product.index');
    }
}
