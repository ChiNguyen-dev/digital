<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Mail\ConfirmOrder;
use App\Services\Interfaces\ICustomerService;
use App\Services\Interfaces\IOrderService;
use App\Services\Interfaces\IProDisWardService;
use App\Services\package\ICartPackage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    private ICustomerService $customerService;
    private IOrderService $orderService;
    private ICartPackage $cartService;
    private IProDisWardService $proDisWardService;

    public function __construct(
        ICartPackage       $cartService,
        IProDisWardService $proDisWardService,
        ICustomerService   $customerService,
        IOrderService      $orderService
    ) {
        $this->proDisWardService = $proDisWardService;
        $this->cartService = $cartService;
        $this->customerService = $customerService;
        $this->orderService = $orderService;
    }

    public function store(Request $request)
    {
        dd($request->all());
        try {
            DB::beginTransaction();
            $province = $this->proDisWardService->getProvinceByMatp($request->province);
            $district = $this->proDisWardService->getDistrictByMaqh($request->district);
            $ward = $this->proDisWardService->getWardByXaid($request->ward);
            $customer = $this->customerService->create([
                'name' => $request->name,
                'email' => $request->email,
                'address' => "$ward->name , $district->name ,$province->name .",
                'phone_number' => $request->phone,
                'password' => Hash::make("admin!@#")
            ]);
            $order = $this->orderService->create([
                'id' => random_int(100000, 999999),
                'customer_id' => $customer->id,
                'total' => $this->cartService->total(),
                'status' => 0,
                'payment_method' => $request->payment_method
            ]);
            $cart = $this->cartService->getCarts();
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
