<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Interfaces\IOrderService;

class AdminDashBoardController extends Controller
{
    private IOrderService $orderService;

    public function __construct(IOrderService $orderService)
    {
        $this->orderService =  $orderService;
        $this->middleware(function ($request, $next) {
            session([ 'active' => 'dashboard']);
            return $next($request);
        });
    }

    public function index()
    {
        $orders = $this->orderService->orderByStatus('ASC');
        $progress = (object)[
            'success' => $orders->where('status', 1)->count(),
            'processing' => $orders->where('status', 0)->count(),
            'revenue' => $orders->where('status', 1)->sum('total'),
            'delete' => $orders->where('deleted_at', '!=', NULL)->count(),
        ];
        $data = $this->orderService->pagination($orders, 15);
        return view('admin.dashboard', compact('progress', 'data'));
    }
}
