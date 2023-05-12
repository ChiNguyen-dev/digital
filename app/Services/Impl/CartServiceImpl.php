<?php

namespace App\Services\Impl;

use App\Dtos\cart\CartDto;
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
            session(['qty' => $carts['count']]);
            if (!$carts['data']->isEmpty()) {
                $cart = $this->model->create([
                    'customer_id' => Auth::guard('client')->id(),
                    'total' => $carts['total']
                ]);
                foreach ($carts['data'] as $item) {
                    $cart->cartItems()->create([
                        'product_id' => $item->id,
                        'color_id' => $item->options['color'],
                        'qty' => $item->qty
                    ]);
                }
            }
            DB::commit();
            $cartPackage->destroy();
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('message:' . $exception->getMessage() . ' Line: ' . $exception->getLine());
        }
    }


    public function getCartsByUserId(int $id)
    {
        $cartByUser = $this->model->where('customer_id', $id)->first();
        if ($cartByUser) {
            return $cartByUser->cartItems;
        }
        return null;
    }
}
