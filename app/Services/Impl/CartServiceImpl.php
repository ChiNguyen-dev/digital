<?php

namespace App\Services\Impl;

use App\Mappers\CartMapper;
use App\Models\Cart;
use App\Services\Abstracts\BaseService;
use App\Services\Interfaces\ICartItemService;
use App\Services\Interfaces\ICartService;
use App\Services\package\ICartPackage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CartServiceImpl extends BaseService implements ICartService
{
    public function getModel(): string
    {
        return Cart::class;
    }

    public function addCart(ICartPackage $cartPackage, ICartItemService $cartItemService)
    {
        try {
            DB::beginTransaction();
            $carts = $cartPackage->getCarts();
            $customer = Auth::guard('client')->user();
            if (!$carts['data']->isEmpty()) {
                $cartByCustomer = $customer->cart;
                if (!empty($cartByCustomer)) {
                    $cartByCustomer->update(['total' => $cartByCustomer->total + $carts['total']]);
                    $cartItemService->addCartItem($cartByCustomer, $carts['data']);
                } else {
                    session(['qty' => $carts['count']]);
                    $cart = $this->model->create([
                        'customer_id' => $customer->id,
                        'total' => $carts['total']
                    ]);
                    $cartItemService->addCartItem($cart, $carts['data']);
                }
            }
            DB::commit();
            $cartPackage->destroy();
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('message:' . $exception->getMessage() . ' Line: ' . $exception->getLine());
        }
    }


    public function getCartsByUserId()
    {
        $customer = Auth::guard('client')->user();
        $cartByCustomer = $customer->cart;
        if (!empty($cartByCustomer)) {
            return $cartByCustomer->cartItems->map(function ($item, $index) use ($cartByCustomer) {
                return CartMapper::toCartItemDTO($item);
            });
        }
    }

    public function destroy(): void
    {
        $customer = Auth::guard('client')->user();
        $cartByCustomer = $customer->cart;
        if (!empty($cartByCustomer)) {
            session()->forget('qty');
            $cartByCustomer->cartItems()->delete();
            $cartByCustomer->delete();
        }
    }
}
