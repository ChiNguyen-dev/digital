<?php

namespace App\Http\Controllers;

use App\Helpers\CategoryRecursive;
use App\Repositories\Interfaces\ICategoryRepository;
use App\Repositories\Interfaces\IProductRepository;
use App\Repositories\Interfaces\ISliderRepository;
use App\Traits\HandleCategoryTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    use HandleCategoryTrait;

    private $categoryRepo;
    private $sliderRepo;
    private $productRepo;
    private $categoryRecursive;

    public function __construct(
        ISliderRepository   $ISliderRepository,
        IProductRepository  $IProductRepository,
        ICategoryRepository $ICategoryRepository,
        CategoryRecursive   $categoryRecursive
    )
    {
        $this->sliderRepo = $ISliderRepository;
        $this->productRepo = $IProductRepository;
        $this->categoryRepo = $ICategoryRepository;
        $this->categoryRecursive = $categoryRecursive;
    }

    public function index()
    {
        $this->setDataCateTrait(app('shared')->get('categories'));
        ['apple-watch' => $appleWatchIds, 'macbook' => $macbookIds, 'iphone' => $iphoneIds]
            = $this->getIdBySlug('apple-watch', 'macbook', 'iphone');
        ['megaMenuHeader' => $megaMenuHeader, 'menuResponse' => $menuResponse] =
            $this->categoryRecursive->menu('megaMenuHeader', 'menuResponse');
        $sliders = $this->sliderRepo->getAll();
        $appleWatchs = $this->productRepo->getItemByCate($appleWatchIds);
        $iphones = $this->productRepo->getItemByCate($iphoneIds);
        $macbooks = $this->productRepo->getItemByCate($macbookIds);
        return
            view('client.home',
                compact(
                    'sliders',
                    'macbooks',
                    'appleWatchs',
                    'iphones',
                    'megaMenuHeader',
                    'menuResponse',
                ));
    }

    public function search(Request $request): JsonResponse
    {
        try {
            $data = $this->productRepo->searchByName($request->name);
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
