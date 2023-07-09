<?php

namespace App\Http\Controllers\Admin;

use App\Mappers\OrderMapper;
use App\Traits\StatisticTrait;
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
    use StatisticTrait;

    private ICustomerService $customerService;
    private IProductService $productService;
    private IColorService $colorService;
    private IOrderService $orderService;

    public function __construct(
        IOrderService    $orderService,
        ICustomerService $customerService,
        IProductService  $productService,
        IColorService    $colorService
    )
    {
        $this->orderService = $orderService;
        $this->customerService = $customerService;
        $this->productService = $productService;
        $this->colorService = $colorService;
        $this->middleware(function ($request, $next) {
            session(['active' => 'sell']);
            return $next($request);
        });
    }

    public function index()
    {
        $statistic = $this->statistic('order');
        $ordersPaginate = $this->orderService->orderByStatus('ASC');
        $orders = $ordersPaginate->map(fn($order, $index) => OrderMapper::toOrderAdminDTO($order));
        return view(
            'admin.orders.index',
            compact(
                'orders',
                'ordersPaginate',
                'statistic'
            )
        );
    }

    public function search(Request $request)
    {
        abort(500, 'The function is developing');
        $customer = $this->customerService->search('name', $request->search);
        if ($customer->isNotEmpty()) {
            $customerId = $customer->modelKeys();
            $ordersPaginate = $this->orderService->findByCustomerIdContaining($customerId);
            $orders = $ordersPaginate->map(fn($order, $index) => OrderMapper::toOrderAdminDTO($order));
        }
    }

    public function update(Request $request): RedirectResponse
    {
        $option = $request->option;
        $ids = $request->check;
        if ($option != null && !empty($ids)) {
            $option = (int)$option;
            if ($option < 2) {
                $this->orderService->updateMany('id', $ids, ['status' => $option]);
            } else {
                $this->orderService->deleteMany($ids);
            }
        }
        return redirect()->route('orders.index');
    }

    public function detail($id)
    {
        $order = $this->orderService->find($id);
        $customer = $order->customer;
        $order_item = DB::table('order_items')->where('order_id', $id)->get([
            'order_items.product_id as product',
            'order_items.color_id as color',
            'order_items.quantity',
        ]);
        $order_item = $order_item->map(function ($v) {
            $v->product = $this->productService->find($v->product);
            $v->color = $this->colorService->find($v->color);
            return $v;
        });
        return view('admin.orders.detail', compact('order', 'customer', 'order_item'));
    }

}
