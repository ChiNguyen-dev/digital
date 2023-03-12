<?php

namespace App\Http\Controllers;

use App\component\CategoryRecursive;
use App\services\ProvinceDistrictWard;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    private $categoryRecursive;
    private $provinceDistrictWard;

    public function __construct(
        CategoryRecursive    $categoryRecursive,
        ProvinceDistrictWard $provinceDistrictWard
    )
    {
        $this->categoryRecursive = $categoryRecursive;
        $this->provinceDistrictWard = $provinceDistrictWard;
    }

    public function index()
    {
        [
            'megaMenuHeader' => $megaMenuHeader, 'menuResponse' => $menuResponse
        ] = $this->categoryRecursive->menu('megaMenuHeader', 'menuResponse');
        $provinces = $this->provinceDistrictWard->getAllProvince();
        return view('client.checkouts.index', compact('megaMenuHeader', 'provinces', 'menuResponse'));
    }

    public function changeAddress(Request $request): JsonResponse
    {
        try {
            $data = $request->type == 1 ?
                $this->provinceDistrictWard->findDistrictBymatp($request->id) :
                $this->provinceDistrictWard->findWardBymaqh($request->id);
            return response()->json([
                'code' => 200,
                'status' => 'Success',
                'data' => $data
            ], 200);
        } catch (\Exception $exception) {
            Log::error('message: ' . $exception->getMessage() . ' Line: ' . $exception->getLine());
            return response()->json([
                'code' => 500,
                'status' => 'Failed',
            ], 500);
        }
    }
}
