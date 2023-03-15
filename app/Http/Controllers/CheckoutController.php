<?php

namespace App\Http\Controllers;

use App\Helpers\CategoryRecursive;
use App\services\imp\ProvinceDistrictWardImp;
use App\services\ProvinceDistrictWard;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    private $categoryRecursive;

    private $IProvinceDistrictWardService;

    public function __construct(CategoryRecursive $categoryRecursive)
    {
        $this->categoryRecursive = $categoryRecursive;
        $this->IProvinceDistrictWardService = new ProvinceDistrictWardImp();
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
