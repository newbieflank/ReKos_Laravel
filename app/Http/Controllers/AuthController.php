<?php

namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\Request;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function register()
    {
        return view('auth.register');
    }

    public function auth_login(Request $request)
    {
        dd($request->all());
    }
}
