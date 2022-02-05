<?php

namespace App\Notifications;

use App\Models\PasswordReset;
use App\Models\PasswordResetCode;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SendResetPasswordCodeNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
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
        if ($this->addCodeToDataBase(Hash::make($code))) {
            return (new MailMessage)
                ->subject('Подверждение email для Сброс парола')
                ->view('reset-password-themplate', ['code' => $code]);
        }
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
    protected function addCodeToDataBase($code)
    {
        return  PasswordReset::updateOrCreate(
            [
                'user_id' => $this->user_id
            ],
            [
                'activation_code' => $code
            ]
        );
    }
}