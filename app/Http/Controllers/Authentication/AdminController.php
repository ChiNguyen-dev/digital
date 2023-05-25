<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index() {
        return view('admin.login');
    }

    public function store(Request $request): RedirectResponse
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
        return redirect()->route('admin.login');
    }
}
