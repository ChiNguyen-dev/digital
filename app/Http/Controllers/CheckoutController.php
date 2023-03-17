<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Helpers\CategoryRecursive;
use Illuminate\Support\Facades\Log;
use App\services\IProvinceDistrictWardService;

class CheckoutController extends Controller
{
    private $categoryRecursive;

    private $IProvinceDistrictWardService;

    public function __construct(CategoryRecursive $categoryRecursive, IProvinceDistrictWardService $IProvinceDistrictWardService)
    {
        $this->categoryRecursive = $categoryRecursive;
        $this->IProvinceDistrictWardService = $IProvinceDistrictWardService;
    }

    public function index()
    {
        [
            'megaMenuHeader' => $megaMenuHeader, 'menuResponse' => $menuResponse
        ] = $this->categoryRecursive->menu('megaMenuHeader', 'menuResponse');
        $provinces = $this->IProvinceDistrictWardService->getAllProvince();
        return view('client.checkouts.index', compact('megaMenuHeader', 'provinces', 'menuResponse'));
    }

    public function changeAddress(Request $request): JsonResponse
    {
        try {
            $data = $request->type == 1 ?
                $this->IProvinceDistrictWardService->findDistrictBymatp($request->id) :
                $this->IProvinceDistrictWardService->findWardBymaqh($request->id);
            return response()->json([
                'code' => 200,
                'status' => 'Success',
                'data' => $data
            ]);
        } catch (\Exception $exception) {
            Log::error('message: ' . $exception->getMessage() . ' Line: ' . $exception->getLine());
            return response()->json([
                'code' => 500,
                'status' => 'Failed',
            ], 500);
        }
    }
}
