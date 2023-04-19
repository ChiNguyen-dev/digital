<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Interfaces\IOrderService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class AdminController extends Controller
{

    private IOrderService $orderService;

    public function __construct(IOrderService $orderService)
    {
        $this->orderService =  $orderService;
        $this->middleware(function ($request, $next) {
            session([
                'active' => 'dashboard',
            ]);
            return $next($request);
        });
    }

    public function index()
    {
        if (Auth::check()) {
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
        return view('admin.login');
    }

    public function store(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->has('remember_me'))) {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->back();
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.index');
    }
}
