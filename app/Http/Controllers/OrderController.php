<?php

namespace App\Http\Controllers;

use App\Mail\ConfirmOrder;
use Illuminate\Http\Request;
use App\services\ICartService;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\OrderRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\services\IProvinceDistrictWardService;
use App\Repositories\Interfaces\IOrderRepository;
use App\Repositories\Interfaces\ICustomerRepository;

class OrderController extends Controller
{
    private $customerRepo;
    private $orderRepo;
    private $cartService;
    private $provinceDistrictWardService;

    public function __construct(
        ICartService $cartService,
        IProvinceDistrictWardService $provinceDistrictWardService,
        ICustomerRepository $customerRepo,
        IOrderRepository $orderRepository
    ) {
        $this->provinceDistrictWardService = $provinceDistrictWardService;
        $this->cartService = $cartService;
        $this->customerRepo = $customerRepo;
        $this->orderRepo = $orderRepository;
    }

    public function store(OrderRequest $request)
    {
        try {
            DB::beginTransaction();
            $address = $this->provinceDistrictWardService->getAddress($request->province, $request->district, $request->ward);
            $customer = $this->customerRepo->create([
                'name' => $request->name,
                'email' => $request->email,
                'address' => $address,
                'phone_number' => $request->phone,
                'password' => Hash::make("admin!@#")
            ]);
            $order = $this->orderRepo->create([
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
