<?php

namespace App\Http\Controllers;

use App\Models\Color;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AdminOrderController extends Controller
{
    private $order;
    private $customer;
    private $product;
    private $color;
    private $numberOfPage = 15;

    public function __construct(Order $order, Customer $customer, Product $product, Color $color)
    {
        $this->order = $order;
        $this->customer = $customer;
        $this->product = $product;
        $this->color = $color;
    }

    public function index(Request $request)
    {
        if ($request->has('search')) {
            $customer = $this->customer->where('name', 'Like', "%{$request->search}%")->get();
            if ($customer->isNotEmpty()) {
                $customerId = $customer->map(function ($v, $k) {
                    return $v->id;
                });
                $orders = $this->order->whereIn('customer_id', $customerId)->latest()->paginate($this->numberOfPage);
            } else {
                $orders = $this->order->where('id', $request->search)->latest()->paginate($this->numberOfPage);
            }
        } else {
            $orders = $this->order->latest()->paginate($this->numberOfPage);
        }
        $progress = (object)[
            'success' => $this->order->where('status', 1)->count(),
            'processing' => $this->order->where('status', 0)->count(),
            'quantity' => $this->order->count('id'),
            'delete' => $this->order->onlyTrashed()->count(),
        ];
        return view('admin.orders.index', compact('orders', 'progress'));
    }

    public function update(Request $request): RedirectResponse
    {
        $option = $request->option;
        $ids = $request->check;
        if ($option != null && !empty($ids)) {
            if ($option < 2) {
                $this->order->whereIn('id', $ids)->update(['status' => $option]);
            } else {
                $this->order->whereIn('id', $ids)->delete();
            }
        }
        return redirect()->route('orders.index');
    }

    public function detail($id)
    {
        $order = $this->order->find($id);
        $customer = $order->customer;
        $order_item = DB::table('order_item')->where('order_id', $id)->get([
            'order_item.product_id as product',
            'order_item.color_id as color',
            'order_item.quantity',
        ]);
        $order_item = $order_item->map(function ($v) {
            $v->product = $this->product->find($v->product);
            $v->color = $this->color->find($v->color);
            return $v;
        });
        return view('admin.orders.detail', compact('order', 'customer', 'order_item'));
    }

}
