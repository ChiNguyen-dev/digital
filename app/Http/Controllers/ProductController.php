<?php

namespace App\Http\Controllers;

use App\component\CategoryRecursive;
use App\component\StracePath;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    private $product;
    private $category;
    private $categoryRecursive;
    private $stracePath;

    public function __construct(
        Product           $product,
        StracePath        $stracePath,
        Category          $category,
        CategoryRecursive $categoryRecursive
    )
    {
        $this->product = $product;
        $this->stracePath = $stracePath;
        $this->category = $category;
        $this->categoryRecursive = $categoryRecursive;
    }

    public function index($categorySlug)
    {
        [
            'megaMenuHeader' => $megaMenuHeader, 'menuResponse' => $menuResponse, 'menuSidebar' => $menuSidebar
        ] = $this->categoryRecursive->menu('megaMenuHeader', 'menuResponse', 'menuSidebar');
        $category = $this->category->where('slug', $categorySlug)->first();
        $products = $this->product->where('status', '1')->get();
        $categoryIds = $this->categoryRecursive->cateIds($categorySlug);
        if (request()->exists('gia-ban') || request()->exists('sap-xep')) {
            if (request()->exists('gia-ban')) {
                switch (request('gia-ban')) {
                    case Str::slug('Dưới 10 triệu'):
                        $products = $products->whereIn('category_id', $categoryIds)->where('price', '<', '10000000');
                        break;
                    case Str::slug('10 - 20 triệu'):
                        $products = $products->whereIn('category_id', $categoryIds)->where('price', '>=', '10000000')->where('price', '<', '20000000');
                        break;
                    case Str::slug('20 - 30 triệu'):
                        $products = $products->whereIn('category_id', $categoryIds)->where('price', '>=', '20000000')->where('price', '<', '30000000');
                        break;
                    case Str::slug('trên 40 triệu'):
                        $products = $products->whereIn('category_id', $categoryIds)->where('price', '>=', '40000000');
                        break;
                }
            }
            if (request()->exists('sap-xep')) {
                $products = $products->whereIn('category_id', $categoryIds)->sortBy('price');
                if (request('sap-xep') == Str::slug('Giá cao đến thấp')) $products = $products->reverse();
            }
        } else {
            $products = $products->whereIn('category_id', $categoryIds);
        }
        return view('client.products.index',
            compact(
                'megaMenuHeader',
                'menuSidebar',
                'menuResponse',
                'products',
                'category',
            ));
    }


    public function detailItem($slug)
    {
        [
            'megaMenuHeader' => $megaMenuHeader, 'menuResponse' => $menuResponse
        ] = $this->categoryRecursive->menu('megaMenuHeader', 'menuResponse');
        $product = $this->product->where('slug', $slug)->first();
        $images = $product->images;
        $stracePath = $this->stracePath->stracePath($product->category_id, $product->name);
        $correlativeItems = $product->tags()->first()->products->filter(function ($value, $key) use ($product) {
            return $value->id != $product->id;
        });
        $correlativeItems = $correlativeItems->take(2);
        return view('client.products.detail',
            compact(
                'megaMenuHeader',
                'product',
                'stracePath',
                'images',
                'correlativeItems',
                'menuResponse',
            ));
    }
}
