<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Mail\ConfirmOrder;
use App\Models\Customer;
use App\Models\Order;
use App\services\CartService;
use App\services\imp\ProvinceDistrictWardImp;
use App\services\ProvinceDistrictWard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    private $customer;
    private $cartService;

    private $provinceDistrictWardService;

    private $order;

    public function __construct(CartService $cartService, Customer $customer, Order $order)
    {
        $this->provinceDistrictWardService = new ProvinceDistrictWardImp();
        $this->cartService = $cartService;
        $this->customer = $customer;
        $this->order = $order;
    }

    public function store(OrderRequest $request)
    {
        try {
            DB::beginTransaction();
            $address = $this->provinceDistrictWardService->getAddress($request->province, $request->district, $request->ward);
            $customer = $this->customer->create([
                'name' => $request->name,
                'email' => $request->email,
                'address' => $address,
                'phone_number' => $request->phone
            ]);
            $order = $this->order->create([
                'id' => random_int(100000, 999999),
                'customer_id' => $customer->id,
                'total' => $this->cartService->total(),
                'status' => 0,
                'payment_method' => $request->payment_method
            ]);
            $cart = $this->cartService->content();
            $cart->map(function ($item) use ($order) {
                $order->products()->attach($item->id, ['quantity' => $item->qty, 'color_id' => $item->options->color]);
            });
            Mail::to($customer->email)->send(
                new ConfirmOrder($order, $customer, $cart, number_format($this->cartService->total(), 0, ',', '.'))
            );
            $this->cartService->destroy();
            DB::commit();
            return redirect()->route('client.home');
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('message: ' . $exception->getMessage() . ' Line: ' . $exception->getLine());
        }
    }
}
