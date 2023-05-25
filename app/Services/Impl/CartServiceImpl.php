<?php

namespace App\Services\Impl;

use App\Dtos\Cart\CartDTO;
use App\Dtos\CartItem\CartItemFormDTO;
use App\Mappers\CartMapper;
use App\Models\Cart;
use App\Models\Customer;
use App\Models\Product;
use App\Services\Abstracts\BaseService;
use App\Services\Interfaces\ICartItemService;
use App\Services\Interfaces\ICartService;
use App\Services\package\ShoppingCart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CartServiceImpl extends BaseService implements ICartService
{
    public function getModel(): string
    {
        return Cart::class;
    }

    public function addToCart(ICartItemService $cartItemService, Product $product, array $options)
    {
        try {
            DB::beginTransaction();
            $user = Auth::guard('client')->user();
            $cart = $this->model->firstOrCreate(
                ['customer_id' => $user->id],
                ['customer_id' => $user->id, 'total' => 0]
            );
            $cartItemService->addToCartItem(
                new CartItemFormDTO($cart->id, $product->id, $options['color_id'], 1)
            );
            $this->updateTotal($user);
            DB::commit();
            return $cart;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('message:' . $exception->getMessage() . ' Line: ' . $exception->getLine());
            return null;
        }
    }

    public function getCartsByUser(Customer $customer): CartDTO
    {
        $cartByCustomer = $customer->cart;
        $cartItemDto = array();
        $total = 0;
        if (!empty($cartByCustomer)) {
            $cartItems = $cartByCustomer->cartItems;
            $total = $cartByCustomer->total;
            if (!empty($cartItems)) {
                $cartItemDto = $cartItems->map(function ($item) {
                    return CartMapper::toCartItemDTO($item);
                })->toArray();
            }
        }
        return CartMapper::toCart($customer, $total, $cartItemDto);
    }

    public function destroy(Customer $customer): void
    {
        $cartByCustomer = $customer->cart;
        if (!empty($cartByCustomer)) {
            session()->forget('qty');
            $cartByCustomer->delete();
        }
    }

    public function updateTotal(Customer $customer): void
    {
        $total = 0;
        $totalAmount = 0;
        $cart = $customer->cart;
        $cartItems = $cart->cartItems;
        if (!empty($cart) && !empty($cartItems)) {
            foreach ($cartItems as $cartItem) {
                $product = $cartItem->product;
                $quantity = $cartItem->qty;
                $total += $product->price * $quantity;
                $totalAmount += $quantity;
            }
        }
        $cart->update(['total' => $total]);
        if ($totalAmount != 0) {
            session(['qty' => $totalAmount]);
        }
    }

    public function checkCartAfterAuthenticate(ICartItemService $cartItemService)
    {
        try {
            $carts = ShoppingCart::getAll();
            $user = Auth::guard('client')->user();
            if (!$carts->isEmpty()) {
                $cart = $this->model->firstOrCreate(
                    ['customer_id' => $user->id],
                    ['customer_id' => $user->id, 'total' => 0]
                );
                $carts->each(function ($item) use ($cart, $cartItemService) {
                    $cartItemService->addToCartItem(
                        new CartItemFormDTO($cart->id, $item->id, $item->options['color_id'], $item->qty)
                    );
                });
                ShoppingCart::destroy();
            }
            $this->updateTotal($user);
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('message:' . $exception->getMessage() . ' Line: ' . $exception->getLine());
        }
    }
}
