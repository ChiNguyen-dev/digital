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

    public function store(Request $request, $id): JsonResponse
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

    public function destroy(): RedirectResponse
    {
        $user = Auth::guard('client')->user();
        $this->cartService->destroy($user);
        return redirect()->route('client.home');
    }

    public function remove($id): JsonResponse
    {
        try {
            $this->cartItemService->delete($id);
            $user = Auth::guard('client')->user();
            $this->cartService->updateTotal($user);
            $cart = $this->cartService->getCartsByUser($user);
            $count = count($cart->getCartItems());
            $total = $cart->getTotal();
            session(['qty' => $count]);
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

    public function updateQuantity(Request $request, $id): JsonResponse
    {
        try {
            $this->cartItemService->find($id)->update($request->all());
            $user = Auth::guard('client')->user();
            $this->cartService->updateTotal($user);
            $cart = $this->cartService->getCartsByUser($user);
            $count = count($cart->getCartItems());
            $total = $cart->getTotal();
            return response()->json([
                'total' => number_format($total, 0, ',', '.') . 'đ',
                'qty' => $count,
            ]);
        } catch (\Exception $exception) {
            Log::error('message: ' . $exception->getMessage() . ' line: ' . $exception->getLine());
            return response()->json([
                'message' => 'Updated failed'
            ], 500);
        }
    }

    public function updateColor(Request $request, $id): JsonResponse
    {
        try {
            $cartItem = $this->cartItemService->find($id);
            $cartItem->update($request->all());
            return response()->json([
                'data' => $cartItem,
                'message' => 'Update successfully.'
            ]);
        } catch (\Exception $exception) {
            Log::error('message: ' . $exception->getMessage() . ' line: ' . $exception->getLine());
            return response()->json([
                'message' => 'Update error.'
            ], 500);
        }
    }
}
