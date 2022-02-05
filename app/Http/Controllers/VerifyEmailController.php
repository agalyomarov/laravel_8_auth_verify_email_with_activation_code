<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Jobs\sendEmailVerificationJob;
use App\Models\EmailActivationCode;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use PhpParser\Node\Expr\FuncCall;

class VerifyEmailController extends Controller
{
    public function notice()
    {
        return view('email-verify');
    }

    public function noticeNew()
    {
        return view('email-verify-new');
    }

    public function send(Request $request)
    {
        $request->user()->sendEmailVerificationCodeNotification($request->user()->id);
        return view('verify-sended');
    }

    public function verify(Request $request)
    {
        if ($request->user()->emailActivationCode instanceof EmailActivationCode) {
            return $this->checkHash($request);
        }
        return back()->with('status', 'Код для подверждение email еще не был отправлен вам');
    }

    protected function deleteActivationCode($id)
    {
        EmailActivationCode::where('id', $id)->delete();
    }

    protected function emailVerification(User $user)
    {
        return $user->update(['email_verified_at' => Carbon::now()]);
    }

    protected function checkCodeCreatedTime(Request $request)
    {
        $created_time_code = Carbon::parse($request->user()->emailActivationCode->created_at);
        $now = Carbon::now();
        return $now->diffInHours($created_time_code) === 0;
    }

    protected function checkHash($request)
    {
        if (Hash::check($request->input('activation_code'), $request->user()->emailActivationCode->activation_code)) {
            if ($this->checkCodeCreatedTime($request)) {
                return $this->verifyEmail($request);
            }
            return back()->with('status', 'Время жизни кода была 1 час.Код устарела.Отправляте новый код');
        }
        return back()->with('activation_code', 'Неправилный код');
    }

    protected function verifyEmail($request)
    {
        $this->deleteActivationCode($request->user()->emailActivationCode->id);
        if ($this->emailVerification($request->user())) {
            return view('verify');
        }
        return abort(500);
    }
}