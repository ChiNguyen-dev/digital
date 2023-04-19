<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Helpers\CategoryRecursive;
use App\Traits\HandleCategoryTrait;
use App\Http\Controllers\Controller;
use App\Services\Interfaces\IProductService;
use App\Services\Interfaces\ISliderService;

class HomeController extends Controller
{
    use HandleCategoryTrait;

    private ISliderService $sliderService;
    private IProductService $productService;
    private CategoryRecursive $categoryRecursive;

    public function __construct(
        ISliderService $sliderService,
        IProductService $productService,
        CategoryRecursive   $categoryRecursive
    ) {
        $this->sliderService = $sliderService;
        $this->productService = $productService;
        $this->categoryRecursive = $categoryRecursive;
    }

    public function index()
    {
        $this->setDataCateTrait(app('shared')->get('categories'));
        ['apple-watch' => $appleWatchIds, 'macbook' => $macbookIds, 'iphone' => $iphoneIds]
            = $this->getIdBySlug('apple-watch', 'macbook', 'iphone');
        ['megaMenuHeader' => $megaMenuHeader, 'menuResponse' => $menuResponse] =
            $this->categoryRecursive->menu('megaMenuHeader', 'menuResponse');
        $sliders = $this->sliderService->getAll();
        $appleWatchs = $this->productService->getItemByCate($appleWatchIds);
        $iphones = $this->productService->getItemByCate($iphoneIds);
        $macbooks = $this->productService->getItemByCate($macbookIds);
        return
            view(
                'client.home',
                compact(
                    'sliders',
                    'macbooks',
                    'appleWatchs',
                    'iphones',
                    'megaMenuHeader',
                    'menuResponse',
                )
            );
    }

    public function search(Request $request): JsonResponse
    {
        try {
            $data = $this->productService->searchByName($request->name);
            return response()->json(['code' => 200, 'data' => $data]);
        } catch (\Exception $exception) {
            Log::error("message: " . $exception->getMessage() . ' Line: ' . $exception->getLine());
            return response()->json([
                'code' => 500,
                'message' => 'Failed!!'
            ], 500);
        }
    }
}
