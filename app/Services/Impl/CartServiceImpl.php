<?php

namespace App\Services\Impl;

use App\Mappers\CartMapper;
use App\Models\Cart;
use App\Models\Customer;
use App\Services\Abstracts\BaseService;
use App\Services\Interfaces\ICartService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CartServiceImpl extends BaseService implements ICartService
{
    public function getModel(): string
    {
        return Cart::class;
    }

    public function addToCart(int $total = 0)
    {
        try {
            DB::beginTransaction();
            $userId = Auth::guard('client')->id();
            $cart = $this->model->updateOrCreate(
                ['customer_id' => $userId],
                [
                    'customer_id' => $userId,
                    'total' => $total
                ]);
            DB::commit();
            return $cart;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('message:' . $exception->getMessage() . ' Line: ' . $exception->getLine());
            return null;
        }
    }


    public function getCartsByUser(Customer $customer)
    {
        $cartByCustomer = $customer->cart;
        if (!empty($cartByCustomer)) {
            return $cartByCustomer->cartItems->map(function ($item, $index) use ($cartByCustomer) {
                return CartMapper::toCartItemDTO($item);
            });
        }
    }

    public function destroy(Customer $customer): void
    {
        $cartByCustomer = $customer->cart;
        if (!empty($cartByCustomer)) {
            session()->forget('qty');
            $cartByCustomer->cartItems()->delete();
            $cartByCustomer->delete();
        }
    }

    public function updateTotal(Customer $customer): void
    {
    }
}
