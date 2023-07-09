<?php

namespace App\Services\Impl;

use App\Dtos\cartItem\CartItemFormDTO;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Customer;
use App\Models\Product;
use App\Services\Abstracts\BaseService;
use App\Services\Interfaces\ICartItemService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CartItemServiceImpl extends BaseService implements ICartItemService
{
    public function getModel(): string
    {
        return CartItem::class;
    }

    public function getTotalAmountItem(Customer $customer): int
    {
        $totalAmount = 0;
        $cartByUser = $customer->cart;
        if (!empty($cartByUser)) {
            $totalAmount = $this->model->where('cart_id', $cartByUser->id)->sum('qty');
        }
        return $totalAmount;
    }

    public function addToCartItem(CartItemFormDTO $cartItemFormDTO)
    {
        try {
            DB::beginTransaction();
            $condition = [
                'cart_id' => $cartItemFormDTO->getCartId(),
                'product_id' => $cartItemFormDTO->getProductId(),
                'color_id' => $cartItemFormDTO->getColorId()
            ];
            $cartItem = $this->model->where('cart_id', $cartItemFormDTO->getCartId())
                ->where('product_id', $cartItemFormDTO->getProductId())
                ->where('color_id', $cartItemFormDTO->getColorId())->first();
            $quantity = empty($cartItem) ? $cartItemFormDTO->getQty() : $cartItem->qty + $cartItemFormDTO->getQty();
            $this->model->updateOrCreate(
                $condition,
                array_merge($condition, ['qty' => $quantity])
            );
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('message: ' . $exception->getMessage() . ' Line: ' . $exception->getLine());
        }
    }
}
