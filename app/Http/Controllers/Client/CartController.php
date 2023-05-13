<?php

namespace App\Http\Controllers\Client;

use App\Helpers\CategoryRecursive;
use App\Http\Controllers\Controller;
use App\Services\Interfaces\ICartItemService;
use App\Services\Interfaces\ICartService;
use App\Services\Interfaces\IProductService;
use App\Services\package\ICartPackage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    private CategoryRecursive $categoryRecursive;
    private IProductService $productService;
    private ICartPackage $cartPackage;
    private ICartService $cartService;
    private ICartItemService $cartItemService;

    public function __construct(
        CategoryRecursive $categoryRecursive,
        IProductService   $productService,
        ICartService      $cartService,
        ICartPackage      $cartPackage,
        ICartItemService  $cartItemService
    )
    {
        $this->categoryRecursive = $categoryRecursive;
        $this->productService = $productService;
        $this->cartService = $cartService;
        $this->cartPackage = $cartPackage;
        $this->cartItemService = $cartItemService;
    }

    public function index()
    {
        $carts = $this->cartService->getCartsByUserId();
        ['megaMenuHeader' => $megaMenuHeader, 'menuResponse' => $menuResponse]
            = $this->categoryRecursive->menu('megaMenuHeader', 'menuResponse');
        return
            view(
                'client.carts.index',
                compact(
                    'megaMenuHeader',
                    'carts',
                    'menuResponse',
                )
            );
    }

    public function add(Request $request, $id): JsonResponse
    {
        try {
            $product = $this->productService->find($id);
            $shopping = $this->cartPackage->addToCart([
                'id' => $product->id,
                'name' => $product->name,
                'qty' => 1,
                'price' => $product->price,
                'options' => ['image' => $product->feature_image_path, 'color' => $request->color_id]
            ]);
            $count = $this->cartPackage->count();
            $isLogin = Auth::guard("client")->check();
            if ($isLogin) $this->cartService->addCart($this->cartPackage, $this->cartItemService);
            return response()->json([
                'quantity' => $count,
                'data' => $shopping,
                'isLogin' => $isLogin,
            ], 201);
        } catch (\Exception $exception) {
            Log::error('message:' . $exception->getMessage() . ' Line: ' . $exception->getLine());
            return response()->json([
                'code' => 500,
                'message' => 'ADD TO CARD ERROR',
            ], 500);
        }
    }

    public function delete(): RedirectResponse
    {
        $this->cartService->destroy();
        return redirect()->route('client.home');
    }

    public function updateQty(Request $request, $id): JsonResponse
    {
        try {
            $this->cartPackage->updateQtyById($id, $request->qty);
            $count = $this->cartPackage->count();
            $total = $this->cartPackage->total();
            return response()->json([
                'total' => number_format($total, 0, ',', '.') . 'đ',
                'qty' => $count,
            ], 200);
        } catch (\Exception $exception) {
            Log::error('message: ' . $exception->getMessage() . ' line: ' . $exception->getLine());
            return response()->json([
                'code' => 500,
                'message' => 'Updated failed'
            ], 500);
        }
    }

    public function deleteItem($id): JsonResponse
    {
        try {
            $this->cartPackage->removeItemById($id);
            $count = $this->cartPackage->count();
            $total = $this->cartPackage->total();
            return response()->json([
                'total' => number_format($total, 0, ',', '.') . 'đ',
                'qty' => $count,
            ], 200);
        } catch (\Exception $exception) {
            Log::error('message: ' . $exception->getMessage() . ' line: ' . $exception->getLine());
            return response()->json([
                'code' => 500,
                'statusText' => 'Failed'
            ], 500);
        }
    }

    public function updateColor(Request $request, $id): JsonResponse
    {
        try {
            $cart = $this->cartPackage->getCartByID($id);
            $shopping = $this->cartPackage->updateColorById($id, ['options' => $cart->options->merge(['color' => $request->id])]);
            return response()->json([
                'message' => 'Update successfully'
            ], 200);
        } catch (\Exception $exception) {
            Log::error('message: ' . $exception->getMessage() . ' line: ' . $exception->getLine());
            return response()->json([
                'statusText' => 'Updated Fail'
            ], 500);
        }
    }
}
