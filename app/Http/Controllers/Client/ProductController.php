<?php

namespace App\Http\Controllers\Client;

use Illuminate\Support\Str;
use App\Helpers\StracePath;
use App\Helpers\CategoryRecursive;
use App\Traits\HandleCategoryTrait;
use App\Http\Controllers\Controller;
use App\Services\Interfaces\ICategoryService;
use App\Services\Interfaces\IProductService;

class ProductController extends Controller
{
    use HandleCategoryTrait;

    private IProductService $productService;
    private ICategoryService $categoryService;
    private CategoryRecursive $categoryRecursive;
    private StracePath $stracePath;

    public function __construct(
        StracePath          $stracePath,
        IProductService  $productService,
        ICategoryService $categoryService,
        CategoryRecursive   $categoryRecursive
    )
    {
        $this->productService = $productService;
        $this->stracePath = $stracePath;
        $this->categoryService = $categoryService;
        $this->categoryRecursive = $categoryRecursive;
    }

    public function index($categorySlug)
    {
        $this->setDataCateTrait(app('shared')->get('categories'));
        ['megaMenuHeader' => $megaMenuHeader, 'menuResponse' => $menuResponse, 'menuSidebar' => $menuSidebar]
            = $this->categoryRecursive->menu('megaMenuHeader', 'menuResponse', 'menuSidebar');
        [$categorySlug => $categoryIds] = $this->getIdBySlug($categorySlug);
        $data = $this->productService->getAllByCateID($categoryIds);
        if (request()->exists('gia-ban') || request()->exists('sap-xep')) {
            if (request()->exists('gia-ban')) {
                switch (request('gia-ban')) {
                    case Str::slug('Dưới 10 triệu'):
                        $data = $data->where('price', '<', '10000000');
                        break;
                    case Str::slug('10 - 20 triệu'):
                        $data = $data->where('price', '>=', '10000000')->where('price', '<', '20000000');
                        break;
                    case Str::slug('20 - 30 triệu'):
                        $data = $data->where('price', '>=', '20000000')->where('price', '<', '30000000');
                        break;
                    case Str::slug('trên 40 triệu'):
                        $data = $data->where('price', '>=', '20000000')->where('price', '>=', '40000000');
                        break;
                }
            }
            if (request()->exists('sap-xep')) {
                $data = $data->sortBy('price');
                if (request('sap-xep') == Str::slug('Giá cao đến thấp')) $data = $data->reverse();
            }
        }
        $category = $this->categoryService->findBySlug($categorySlug);
        $products = $this->productService->pagination($data, 15);
        return
            view('client.products.index',
                compact(
                    'megaMenuHeader',
                    'menuSidebar',
                    'menuResponse',
                    'products',
                    'category',
                )
            );
    }


    public function detailItem($slug)
    {
        ['megaMenuHeader' => $megaMenuHeader, 'menuResponse' => $menuResponse]
         = $this->categoryRecursive->menu('megaMenuHeader', 'menuResponse');
        $product = $this->productService->getItemBySlug($slug);
        $itemsRelated = $this->productService->getItemsRelated($product->category_id);
        $stracePath = $this->stracePath->stracePath($product->category_id, $product->name);
        return
            view('client.products.detail',
                compact(
                    'megaMenuHeader',
                    'product',
                    'stracePath',
                    'itemsRelated',
                    'menuResponse',
                )
            );
    }
}
