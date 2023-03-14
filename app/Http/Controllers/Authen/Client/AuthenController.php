<?php

namespace App\Http\Controllers\Authen\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClientLoginRequest;
use App\Models\Customer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenController extends Controller
{
    private $customer;

    public function __construct(Customer $customer)
    {
        $this->customer = $customer;
    }

    public function index()
    {
        return view('client.login');
    }

    public function store(ClientLoginRequest $request)
    {
        $customerLogin = $this->customer->where('email', $request->email)->first();
        if (!empty($customerLogin)) {
            session()->put('user', $customerLogin);
            return redirect()->route('carts.index');
        }
        return view('client.login');
    }

    public function register()
    {
        return view('client.register');
    }

    public function logout(): RedirectResponse
    {
        session()->flush();
        return redirect()->route('client.home');
    }
}
