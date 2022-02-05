<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use GuzzleHttp\RetryMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function show()
    {
        return view('login');
    }
    public function authenticate(LoginRequest $request)
    {
        $data = $request->validated();
        $remember_me = false;
        if (isset($data['remember_me'])) {
            // global $remember_me;
            $remember_me = true;
            unset($data['remember_me']);
        }
        if (Auth::attempt($data, $remember_me)) {
            $request->session()->regenerate();
            return redirect()->intended('/');
        }
        return back()->withErrors([
            'email' => 'Email или парол веден неправилный',
        ]);
    }
}