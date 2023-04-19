<?php

namespace App\Http\Controllers\Client;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Helpers\CategoryRecursive;
use App\Services\Interfaces\IProDisWardService;

class CheckoutController extends Controller
{
    private CategoryRecursive $categoryRecursive;

    private IProDisWardService $proDisWardService;

    public function __construct(CategoryRecursive $categoryRecursive, IProDisWardService $proDisWardService)
    {
        $this->categoryRecursive = $categoryRecursive;
        $this->proDisWardService = $proDisWardService;
    }

    public function index(Request $request)
    {
        $customer = Auth::guard('client')->user();
        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Success',
                'data'  => $customer
            ], 200);
        }
        [
            'megaMenuHeader' => $megaMenuHeader, 'menuResponse' => $menuResponse
        ] = $this->categoryRecursive->menu('megaMenuHeader', 'menuResponse');
        $provinces = $this->proDisWardService->getProvinces();
        return
            view(
                'client.checkouts.index',
                compact(
                    'megaMenuHeader',
                    'provinces',
                    'menuResponse',
                    'customer'
                )
            );
    }

    public function changeAddress(Request $request): JsonResponse
    {
        try {
            $id = $request->id;
            $data = null;
            $code = 422;
            if (Str::upper($request->key) == 'PROVINCE') {
                $code = 200;
                $data = $this->proDisWardService->getDistrictsByMatp($id);
            }
            if (Str::upper($request->key) == 'DISTRICT') {
                $code = 200;
                $data = $this->proDisWardService->getWardsByMaqh($id);
            }
            return response()->json([
                'message' => 'Successfully',
                'data' => $data
            ],  $code);
        } catch (\Exception $exception) {
            Log::error('message: ' . $exception->getMessage() . ' Line: ' . $exception->getLine());
            return response()->json([
                'code' => 500,
                'status' => 'Failed',
            ], 500);
        }
    }
}
