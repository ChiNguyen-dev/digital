<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use App\Helpers\CategoryRecursive;
use App\Services\Interfaces\ICartService;
use App\Services\Interfaces\IProductService;

class CartController extends Controller
{
    private CategoryRecursive $categoryRecursive;
    private ICartService $cartService;
    private IProductService $productService;

    public function __construct(
        CategoryRecursive $categoryRecursive,
        IProductService $productService,
        ICartService $cartService
    ) {
        $this->categoryRecursive = $categoryRecursive;
        $this->productService = $productService;
        $this->cartService = $cartService;
    }

    public function index()
    {
        $count = $this->cartService->count();
        $total = $this->cartService->total();
        $shopping = $this->cartService->getCarts();
        ['megaMenuHeader' => $megaMenuHeader, 'menuResponse' => $menuResponse]
            = $this->categoryRecursive->menu('megaMenuHeader', 'menuResponse');
        return
            view(
                'client.carts.index',
                compact(
                    'megaMenuHeader',
                    'count',
                    'total',
                    'shopping',
                    'menuResponse',
                )
            );
    }

    public function add(Request $request, $id): JsonResponse
    {
        try {
            $product = $this->productService->find($id);
            $shopping = $this->cartService->addToCart([
                'id' => $product->id,
                'name' => $product->name,
                'qty' => 1,
                'price' => $product->price,
                'options' => ['image' => $product->feature_image_path, 'color' => $request->color_id]
            ]);
            $count = $this->cartService->count();
            return response()->json([
                'quantity' => $count,
                'data' => $shopping,
                'message' => 'ADD TO CARD SUCCESSFULLY',
            ], 200);
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
            $this->cartService->updateQtyById($id, $request->qty);
            $count = $this->cartService->count();
            $total = $this->cartService->total();
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
            $this->cartService->removeItemById($id);
            $count = $this->cartService->count();
            $total = $this->cartService->total();
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
            $cart = $this->cartService->getCartByID($id);
            $shopping = $this->cartService->updateColorById($id, ['options' => $cart->options->merge(['color' => $request->id])]);
            return response()->json([
                'message' => 'Uploaded successfully'
            ], 200);
        } catch (\Exception $exception) {
            Log::error('message: ' . $exception->getMessage() . ' line: ' . $exception->getLine());
            return response()->json([
                'statusText' => 'Updated Fail'
            ], 500);
        }
    }
}
