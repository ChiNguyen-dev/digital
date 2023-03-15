<?php

namespace App\Http\Controllers;

use App\Helpers\CategoryRecursive;
use App\Models\Product;
use App\services\CartService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    private $categoryRecursive;
    private $cartService;

    private $product;

    public function __construct(CategoryRecursive $categoryRecursive, Product $product, CartService $cartService)
    {
        $this->categoryRecursive = $categoryRecursive;
        $this->product = $product;
        $this->cartService = $cartService;
    }

    public function index()
    {
        $count = $this->cartService->count();
        $total = $this->cartService->total();
        $shopping = $this->cartService->content();
        [
            'megaMenuHeader' => $megaMenuHeader, 'menuResponse' => $menuResponse
        ] = $this->categoryRecursive->menu('megaMenuHeader', 'menuResponse');
        return view('client.carts.index',
            compact(
                'megaMenuHeader',
                'count',
                'total',
                'shopping',
                'menuResponse',
            ));
    }

    public function add(Request $request, $id): JsonResponse
    {
        try {
            $product = $this->product->find($id);
            $count = $this->cartService->count();
            $shopping = $this->cartService->add([
                'id' => $product->id,
                'name' => $product->name,
                'qty' => 1,
                'price' => $product->price,
                'options' => ['image' => $product->feature_image_path, 'color' => $request->color_id]]);
            return response()->json([
                'code' => 200,
                'quantity' => $count,
                'data' => $shopping,
                'statusText' => 'added to cart success'
            ], 200);
        } catch (\Exception $exception) {
            Log::error('message:' . $exception->getMessage() . ' Line: ' . $exception->getLine());
            return response()->json([
                'code' => 500,
                'statusText' => 'added to cart fail'
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
                'code' => 200,
                'total' => number_format($total, 0, ',', '.') . 'đ',
                'qty' => $count,
                'statusText' => 'success'
            ], 200);
        } catch (\Exception $exception) {
            Log::error('message: ' . $exception->getMessage() . ' line: ' . $exception->getLine());
            return response()->json([
                'code' => 500,
                'statusText' => 'Fail'
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
                'code' => 200,
                'id' => $id,
                'total' => number_format($total, 0, ',', '.') . 'đ',
                'qty' => $count,
                'statusText' => 'success'
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
            $cart = $this->cartService->findItemByid($id);
            $shopping = $this->cartService->updateColorById($id, ['options' => $cart->options->merge(['color' => $request->id])]);
            return response()->json([
                'code' => 200,
                'cart' => $shopping,
                'statusText' => 'success'
            ], 200);
        } catch (\Exception $exception) {
            Log::error('message: ' . $exception->getMessage() . ' line: ' . $exception->getLine());
            return response()->json([
                'code' => 500,
                'statusText' => 'Fail'
            ], 500);
        }

    }
}
