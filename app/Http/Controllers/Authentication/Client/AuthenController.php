<?php

namespace App\Http\Controllers\Authentication\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClientLoginRequest;
use App\Services\Interfaces\ICartItemService;
use App\Services\Interfaces\ICartService;
use App\Services\Interfaces\ICustomerService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenController extends Controller
{
    private ICustomerService $customerService;
    private ICartItemService $cartItemService;
    private ICartService $cartService;

    public function __construct(ICustomerService $customerService, ICartItemService $cartItemService, ICartService $cartService)
    {
        $this->customerService = $customerService;
        $this->cartItemService = $cartItemService;
        $this->cartService = $cartService;
    }

    public function index()
    {
        return view('client.login');
    }

    public function store(ClientLoginRequest $request): RedirectResponse
    {
        if (Auth::guard('client')->attempt($request->only(['email', 'password']))) {
            $this->cartService->checkCartAfterAuthenticate($this->cartItemService);
            $intendedUrl = session('intended_url');
            session()->forget('intended_url');
            return redirect()->to($intendedUrl);
        }
        return redirect()->back();
    }

    public function create()
    {
        return view('client.register');
    }

    public function register(Request $request): RedirectResponse
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
        $quantity = session('qty');
        Auth::guard('client')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        if (!session()->has('qty')) session(['qty' => $quantity]);
        return redirect()->route('client.home');
    }
}
