<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use GuzzleHttp\RetryMiddleware;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function show()
    {
        return view('register');
    }
    public function store(RegisterRequest $request)
    {
        $data = $request->validated();
        // dd($data);
        try {
            DB::beginTransaction();
            $user = User::create(
                [
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'password' => Hash::make($data['password'])
                ]
            );
            event(new Registered($user));
            Auth::login($user);
            DB::commit();
            return redirect()->route('verification.notice');
        } catch (\Exception $exception) {
            DB::rollBack();
            // dd($exception);
            return abort(500);
        }
    }
}