<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{

    private $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function index()
    {
        if (Auth::check()) {
            $progress = (object)[
                'success' => $this->order->where('status', 1)->count(),
                'processing' => $this->order->where('status', 0)->count(),
                'revenue' => $this->order->where('status', 1)->sum('total'),
                'delete' => $this->order->onlyTrashed()->count(),
            ];
            $data = $this->order->with('customer')->latest()->paginate(15);
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
