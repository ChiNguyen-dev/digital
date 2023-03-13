<?php

namespace App\Http\Controllers\Authen\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenController extends Controller
{
    public function index()
    {
        return view('client.login');
    }

    public function register()
    {
        return view('client.register');
    }

}
