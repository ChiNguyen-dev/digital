<?php

namespace App\Http\Controllers\Client;

use App\Http\Resources\CustomerResource;
use App\Services\Interfaces\ICartService;
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
    private ICartService $cartService;
    private IProDisWardService $proDisWardService;

    public function __construct(
        CategoryRecursive $categoryRecursive,
        ICartService $cartService,
        IProDisWardService $proDisWardService)
    {
        $this->categoryRecursive = $categoryRecursive;
        $this->proDisWardService = $proDisWardService;
        $this->cartService = $cartService;
    }

    public function index(Request $request)
    {
        $user = Auth::guard('client')->user();
        $carts = $this->cartService->getCartsByUser($user);
        $customerVariants = $user->customerVariants;
        if ($request->expectsJson()) {
            $variant = $customerVariants->find($request->id);
            return response()->json([
                'message' => 'Success',
                'data'  => new CustomerResource($variant)
            ]);
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
                    'carts',
                    'customerVariants',
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
