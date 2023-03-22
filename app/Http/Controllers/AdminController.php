<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Repositories\Interfaces\IOrderRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{

    private $orderRepo;

    public function __construct(IOrderRepository $iOrderRepository)
    {
        $this->orderRepo =  $iOrderRepository;
    }

    public function index()
    {
        if (Auth::check()) {
            $orders = $this->orderRepo->orderByStatus('ASC');
            $progress = (object)[
                'success' => $orders->where('status', 1)->count(),
                'processing' => $orders->where('status', 0)->count(),
                'revenue' => $orders->where('status', 1)->sum('total'),
                'delete' => $orders->where('deleted_at', '!=', NULL)->count(),
            ];
            $data = $this->orderRepo->pagination($orders, 15);
            return view('admin.dashboard', compact('progress', 'data'));
        }
        return view('admin.login');
    }

    public function store(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->has('remember_me'))) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.login');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.index');
    }
}
