<?php

namespace App\Http\Controllers\Authentication\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClientLoginRequest;
use App\Services\Interfaces\ICustomerService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenController extends Controller
{
    private ICustomerService $customerService;

    public function __construct(ICustomerService $customerService)
    {
        $this->customerService = $customerService;
    }

    public function index()
    {
        return view('client.login');
    }

    public function store(ClientLoginRequest $request)
    {
        if (Auth::guard('client')->attempt([
            'email' =>  $request->email,
            'password' => $request->password
        ], false)) {
            $intendedUrl = session('intended_url');
            session()->forget('intended_url');
            return redirect()->to($intendedUrl);
        }
        return redirect()->back();
    }

    public function register()
    {
        return view('client.register');
    }

    public function addCustommer(Request $request)
    {
        $req = [
            'name' => $request->name,
            'email' => $request->email,
            'address' => 'default',
            'phone_number' => $request->phone_number,
            'password' => bcrypt($request->password)
        ];
        $this->customerService->create($req);
        return redirect()->route('client.home');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::guard('client')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('client.home');
    }
}