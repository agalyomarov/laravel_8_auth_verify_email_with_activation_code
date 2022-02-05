<?php

namespace App\Notifications;

use App\Mail\SendVerifyEmailMail;
use Carbon\Carbon;
use GrahamCampbell\ResultType\Result;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SendVerifyCodeWithQueueNotification extends Notification implements ShouldQueue
{
    use Queueable;
    protected $user_id;
    public function __construct($user_id)
    {
        $this->user_id = $user_id;
    }
    public function via($notifiable)
    {
        return ['mail'];
    }
    public function toMail($notifiable)
    {
        $code = $this->generateCode();
        $this->addCodeToDataBase(Hash::make($code));
        return (new MailMessage)
            ->subject('Подверждение email')
            ->view('verify-email-themplate', ['code' => $code]);
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
    protected function generateCode()
    {
        return mt_rand(111111, 999999);
    }
    public function addCodeToDataBase($code)
    {
        DB::table('email_activation_codes')->updateOrInsert(
            [
                'user_id' => $this->user_id,
            ],
            [
                'activation_code' => $code,
                'created_at' => Carbon::now()
            ],

        );
    }
}