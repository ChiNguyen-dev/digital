<?php

namespace App\Http\Controllers\Client;

use App\Helpers\CategoryRecursive;
use App\Http\Controllers\Controller;
use App\Services\Interfaces\ICartItemService;
use App\Services\Interfaces\ICartService;
use App\Services\Interfaces\IProductService;
use App\Services\package\ShoppingCart;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    private CategoryRecursive $categoryRecursive;
    private IProductService $productService;
    private ICartService $cartService;
    private ICartItemService $cartItemService;

    public function __construct(
        CategoryRecursive $categoryRecursive,
        IProductService   $productService,
        ICartService      $cartService,
        ICartItemService  $cartItemService
    )
    {
        $this->categoryRecursive = $categoryRecursive;
        $this->productService = $productService;
        $this->cartService = $cartService;
        $this->cartItemService = $cartItemService;
    }

    public function index()
    {
        $user = Auth::guard('client')->user();
        $carts = $this->cartService->getCartsByUser($user);
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
            $isLogin = Auth::guard("client")->check();
            $product = $this->productService->find($id);
            $options = $request->all();
            if ($isLogin) {
                $this->cartService->addToCart($this->cartItemService, $product, $options);
            } else {
                ShoppingCart::addToCart($product, $options);
                session()->put('qty', ShoppingCart::count());
            }
            $quantity = session('qty');
            return response()->json([
                'quantity' => $quantity,
                'isLogin' => $isLogin,
            ]);
        } catch (\Exception $exception) {
            Log::error('message:' . $exception->getMessage() . ' Line: ' . $exception->getLine());
            return response()->json([
                'message' => 'Add to cart error.',
            ], 500);
        }
    }

    public function delete(): RedirectResponse
    {
        $user = Auth::guard('client')->user();
        $this->cartService->destroy($user);
        return redirect()->route('client.home');
    }

    public function updateQty(Request $request, $id): JsonResponse
    {
        try {
            ShoppingCart::updateQuantity($id, $request->qty);
            $count = ShoppingCart::count();
            $total = ShoppingCart::total();
            return response()->json([
                'total' => number_format($total, 0, ',', '.') . 'đ',
                'qty' => $count,
            ], 200);
        } catch (\Exception $exception) {
            Log::error('message: ' . $exception->getMessage() . ' line: ' . $exception->getLine());
            return response()->json([
                'message' => 'Updated failed'
            ], 500);
        }
    }

    public function deleteItem($id): JsonResponse
    {
        try {
            ShoppingCart::destroy($id);
            $count = ShoppingCart::count();
            $total = ShoppingCart::total();
            return response()->json([
                'total' => number_format($total, 0, ',', '.') . 'đ',
                'qty' => $count,
            ]);
        } catch (\Exception $exception) {
            Log::error('message: ' . $exception->getMessage() . ' line: ' . $exception->getLine());
            return response()->json([
                'statusText' => 'Failed'
            ], 500);
        }
    }

    public function updateColor(Request $request, $id): JsonResponse
    {
        try {
            $cart = ShoppingCart::findById($id);
            ShoppingCart::update($id, ['options' => $cart->options->merge(['color' => $request->id])]);
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
