<?php

namespace App\Http\Controllers;

use App\component\CategoryRecursive;
use App\Models\Product;
use App\Models\Slider;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    private $slider;
    private $product;
    private $categoryRecursive;

    public function __construct(Slider $slider, Product $product, CategoryRecursive $categoryRecursive)
    {
        $this->slider = $slider;
        $this->product = $product;
        $this->categoryRecursive = $categoryRecursive;
    }

    public function index()
    {
        $sliders = $this->slider->all();
        [
            'apple-watch' => $appleWatchIds, 'macbook' => $macbookIds, 'iphone' => $iphoneIds
        ] = $this->categoryRecursive->getIdBySlug('apple-watch', 'macbook', 'iphone');
        [
            'megaMenuHeader' => $megaMenuHeader, 'menuResponse' => $menuResponse
        ] = $this->categoryRecursive->menu('megaMenuHeader', 'menuResponse');
        $appleWatchs = $this->product->where('status', 1)->latest()->whereIn('category_id', $appleWatchIds)->get();
        $iphones = $this->product->where('status', 1)->latest()->whereIn('category_id', $iphoneIds)->take(8)->get();
        $macbooks = $this->product->where('status', 1)->latest()->whereIn('category_id', $macbookIds)->take(8)->get();

        return view('client.home',
            compact(
                'sliders',
                'macbooks',
                'megaMenuHeader',
                'appleWatchs',
                'menuResponse',
                'iphones',
            ));
    }

    /**
     * Filter Product Ajax
     * @param Request $request
     * @return JsonResponse
     */
    public function search(Request $request): JsonResponse
    {
        try {
            $data = $this->product->where('name', 'LIKE', "%{$request->name}%")->get()->take(5);
            $data->map(function ($item, $key) {
                $item->feature_image_path = asset($item->feature_image_path);
            });
            return response()->json([
                'code' => 200,
                'data' => $data
            ]);
        } catch (\Exception $exception) {
            Log::error("message: " . $exception->getMessage() . ' Line: ' . $exception->getLine());
            return response()->json([
                'code' => 500,
                'message' => 'Failed!!'
            ], 500);
        }
    }
}
