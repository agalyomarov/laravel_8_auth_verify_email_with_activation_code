<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\PasswordReset as ModelsPasswordReset;
use App\Models\User;
use App\Notifications\SendResetPasswordCodeNotification;
use Carbon\Carbon;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class PasswordController extends Controller
{
    public function request()
    {
        return view('forgot-password');
    }

    public function email(Request $request)
    {
        $request->validate(['email' => ['required', 'exists:users,email']]);
        $user = User::where('email', $request->input('email'))->first();
        $user->sendPasswordResetNotification($user->id);
        return redirect()->route('password.reset');
    }

    public function reset()
    {
        return view('reset-password');
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'activation_code' => ['required'],
            'email' => ['required', 'email:filter', 'exists:users,email'],
            'password' => ['required', 'confirmed'],
        ]);

        $user = User::where('email', $data['email'])->first();
        return $this->chechRecord($request, $user);
    }

    protected function checkCodeCreatedTime($user)
    {
        $created_time_code = Carbon::parse($user->passwordReset->created_at);
        $now = Carbon::now();
        return $now->diffInHours($created_time_code) === 0;
    }

    protected function deleteActivationCode($id)
    {
        ModelsPasswordReset::where('id', $id)->delete();
    }

    protected function chechRecord($request, $user)
    {
        if ($user->passwordReset instanceof ModelsPasswordReset) {
            return $this->chechHash($request, $user);
        }
        return back()->with('status', 'Код еще не был отправлен');
    }

    protected function chechHash($request, $user)
    {
        if (Hash::check($request->input('activation_code'), $user->passwordReset->activation_code)) {
            if ($this->checkCodeCreatedTime($user)) {
                return $this->updatePassword($request, $user);
            }
            return back()->with('status', 'Время жизни кода была 1 час.Код устарела.Отправляте новый код');
        }
        return back()->with('code', 'Неправилный код');
    }

    protected function updatePassword($request, $user)
    {
        $this->deleteActivationCode($user->passwordReset->id);
        $result = $user->update(['password' => Hash::make($request->input(['password']))]);
        event(new PasswordReset($user));
        if ($result) {
            return redirect()->route('login');
        }
        return abort(500);
    }
}