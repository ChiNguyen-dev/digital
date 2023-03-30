<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\IColorRepository;
use App\Repositories\Interfaces\ICustomerRepository;
use App\Repositories\Interfaces\IOrderRepository;
use App\Repositories\Interfaces\IProductRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminOrderController extends Controller
{
    private ICustomerRepository $customerRepo;
    private IProductRepository $productRepo;
    private IColorRepository $colorRepo;
    private IOrderRepository $orderRepo;
    private $numberOfPage = 15;

    public function __construct(
        IOrderRepository $iOrderRepository,
        ICustomerRepository $iCustomerRepository,
        IProductRepository $iProductRepository,
        IColorRepository $iColorRepository
    ) {
        $this->orderRepo = $iOrderRepository;
        $this->customerRepo = $iCustomerRepository;
        $this->productRepo = $iProductRepository;
        $this->colorRepo = $iColorRepository;
    }

    public function index(Request $request)
    {
        $orders = $this->orderRepo->orderByStatus('ASC');
        if ($request->has('search')) {
            $customer = $this->customerRepo->search('name', $request->search);
            if ($customer->isNotEmpty()) {
                $customerId = $customer->modelKeys();
                $orders = $orders->whereIn('customer_id', $customerId);
            } else {
                $orders = $orders->where('id', $request->search);
            }
        }
        $orders = $this->orderRepo->pagination($orders, $this->numberOfPage);
        $progress = (object)[
            'success' => $orders->where('status', 1)->count(),
            'processing' => $orders->where('status', 0)->count(),
            'quantity' => $orders->count('id'),
            'delete' => $this->orderRepo->countSoftDelete(),
        ];
        return view('admin.orders.index', compact('orders', 'progress'));
    }

    public function update(Request $request): RedirectResponse
    {
        $option = $request->option;
        $ids = $request->check;
        if ($option != null && !empty($ids)) {
            if ($option < 2) {
                $this->orderRepo->updateMany('id', $ids, ['status' => $option]);
            } else {
                $this->orderRepo->deleteMany('id', $ids);
            }
        }
        return redirect()->route('orders.index');
    }

    public function detail($id)
    {
        $order = $this->orderRepo->find($id);
        $customer = $order->customer;
        $order_item = DB::table('order_item')->where('order_id', $id)->get([
            'order_item.product_id as product',
            'order_item.color_id as color',
            'order_item.quantity',
        ]);
        $order_item = $order_item->map(function ($v) {
            $v->product = $this->productRepo->find($v->product);
            $v->color = $this->colorRepo->find($v->color);
            return $v;
        });
        return view('admin.orders.detail', compact('order', 'customer', 'order_item'));
    }
}
