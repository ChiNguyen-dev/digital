<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Mail\ConfirmOrder;
use App\Mappers\CartMapper;
use App\Services\Interfaces\ICartService;
use App\Services\Interfaces\ICustomerVariantService;
use App\Services\Interfaces\IOrderService;
use App\Services\Interfaces\IProDisWardService;
use App\Services\Interfaces\IStatisticService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    private IOrderService $orderService;
    private IProDisWardService $proDisWardService;
    private ICartService $cartService;
    private ICustomerVariantService $customerVariantService;
    private IStatisticService $statisticService;
    public function __construct(
        IProDisWardService      $proDisWardService,
        IOrderService           $orderService,
        ICartService            $cartService,
        ICustomerVariantService $customerVariantService,
        IStatisticService $statisticService
    )
    {
        $this->proDisWardService = $proDisWardService;
        $this->orderService = $orderService;
        $this->cartService = $cartService;
        $this->statisticService = $statisticService;
        $this->customerVariantService = $customerVariantService;
    }

    public function store(OrderRequest $request)
    {
        try {
            DB::beginTransaction();
            $address = $request->address;
            if ($request->has('province')) {
                if (!$request->has('district') && !$request->has('ward')) {
                    $reqData = [
                        $request->only('province'),
                        ['province' => 'bail|required|string|min:10'],
                        ['province.required' => 'Tỉnh thành không được trống',]
                    ];
                } else {
                    if (!$request->has('ward')) {
                        $reqData = [
                            $request->only('district'),
                            ['district' => 'bail|required|string|min:4',],
                            ['district.required' => 'Quận, huyện không được trống',]
                        ];
                    } else {
                        $reqData = [
                            $request->only('ward'),
                            ['ward' => 'bail|required|string|min:4',],
                            ['ward.required' => 'Phường, xã không được trống',]
                        ];
                    }
                }
                $validator = Validator::make(...$reqData);
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }
                $province = $this->proDisWardService->getProvinceByMatp($request->province);
                $district = $this->proDisWardService->getDistrictByMaqh($request->district);
                $ward = $this->proDisWardService->getWardByXaid($request->ward);
                $address = "$request->address , $ward->name , $district->name ,$province->name .";
            }
            $statistic = $this->statisticService->find(1);
            $customer = Auth::guard('client')->user();
            $cart = $customer->cart;
            $cartItems = $cart->cartItems;
            $variant = $this->customerVariantService->create([
                'name' => $request->name,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'address' => $address,
                'customer_id' => $customer->id
            ]);
            $order = $this->orderService->create([
                'customer_variants_id' => $variant->id,
                'customer_id' => $customer->id,
                'total' => $cart->total,
                'status' => 0,
                'payment_method' => $request->payment_method,
                'code' => str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT)
            ]);
            $cartItems->each(fn($cartItem) => $order->orderItems()->create([
                'product_id' => $cartItem->product_id,
                'color_id' => $cartItem->color_id,
                'quantity' => $cartItem->qty
            ]));
            $statistic->update(['processing' => $statistic->processing + 1]);
            $cartItems = $cartItems->map(fn($cartItem) => CartMapper::toCartItemDTO($cartItem));
            Mail::to($variant->email)->send(
                new ConfirmOrder($order, $variant, $cartItems, $cart->total)
            );
            $cart->delete();
            session()->forget('qty');
            DB::commit();
            return redirect()->route('client.home');
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('message: ' . $exception->getMessage() . ' Line: ' . $exception->getLine());
        }
    }
}
