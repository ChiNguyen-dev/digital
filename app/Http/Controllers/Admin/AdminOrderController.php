<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Services\Interfaces\IColorService;
use App\Services\Interfaces\ICustomerService;
use App\Services\Interfaces\IOrderService;
use App\Services\Interfaces\IProductService;
use Illuminate\Http\RedirectResponse;


class AdminOrderController extends Controller
{
    private ICustomerService $customerService;
    private IProductService $productService;
    private IColorService $colorService;
    private IOrderService $orderService;
    private $numberOfPage = 15;

    public function __construct(
        IOrderService $orderService,
        ICustomerService $customerService,
        IProductService $productService,
        IColorService $colorService
    ) {
        $this->orderService = $orderService;
        $this->customerService = $customerService;
        $this->productService = $productService;
        $this->colorService = $colorService;
        $this->middleware(function ($request, $next) {
            session([
                'active' => 'sell',
            ]);
            return $next($request);
        });
    }

    public function index(Request $request)
    {
        $orders = $this->orderService->orderByStatus('ASC');
        if ($request->has('search')) {
            $customer = $this->customerService->search('name', $request->search);
            if ($customer->isNotEmpty()) {
                $customerId = $customer->modelKeys();
                $orders = $orders->whereIn('customer_id', $customerId);
            } else {
                $orders = $orders->where('id', $request->search);
            }
        }
        $orders = $this->orderService->pagination($orders, $this->numberOfPage);
        $progress = (object)[
            'success' => $orders->where('status', 1)->count(),
            'processing' => $orders->where('status', 0)->count(),
            'quantity' => $orders->count('id'),
            'delete' => $this->orderService->countSoftDelete(),
        ];
        return view('admin.orders.index', compact('orders', 'progress'));
    }


    public function update(Request $request): RedirectResponse
    {
        $option = $request->option;
        $ids = $request->check;
        if ($option != null && !empty($ids)) {
            if ($option < 2) {
                $this->orderService->updateMany('id', $ids, ['status' => $option]);
            } else {
                $this->orderService->deleteMany('id', $ids);
            }
        }
        return redirect()->route('orders.index');
    }

    public function detail($id)
    {
        $order = $this->orderService->find($id);
        $customer = $order->customer;
        $order_item = DB::table('order_item')->where('order_id', $id)->get([
            'order_item.product_id as product',
            'order_item.color_id as color',
            'order_item.quantity',
        ]);
        $order_item = $order_item->map(function ($v) {
            $v->product = $this->productService->find($v->product);
            $v->color = $this->colorService->find($v->color);
            return $v;
        });
        return view('admin.orders.detail', compact('order', 'customer', 'order_item'));
    }
}
