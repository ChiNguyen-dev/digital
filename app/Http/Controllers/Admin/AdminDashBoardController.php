<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mappers\OrderMapper;
use App\Services\Interfaces\ICustomerVariantService;
use App\Traits\StatisticTrait;
use Illuminate\Support\Arr;

class AdminDashBoardController extends Controller
{
    use StatisticTrait;
    private ICustomerVariantService $customerVariantService;

    public function __construct(ICustomerVariantService $customerVariantService)
    {
        $this->customerVariantService = $customerVariantService;
        $this->middleware(function ($request, $next) {
            session(['active' => 'dashboard']);
            return $next($request);
        });
    }

    public function index()
    {
        $statistic = $this->statistic('dashboard');
        $customer_variant_pagination = $this->customerVariantService->getAll();
        $orders = $customer_variant_pagination->map(fn($customer) => OrderMapper::toOrderDashboard($customer));
        $progress = (object)[
            'success' => $statistic->order_success,
            'processing' => $statistic->order_processing,
            'revenue' => $statistic->revenue,
            'delete' => $statistic->order_cancel,
        ];
        $orders = collect(Arr::collapse([...$orders]));
        $orders = $orders->filter(fn($order) => !$order->isStatus())->merge(
            $orders->filter(fn($order) => $order->isStatus())
        );
        return view(
            'admin.dashboard', compact(
                'progress',
                'customer_variant_pagination',
                'orders'
            )
        );
    }
}
