<?php

namespace App\Models;

use App\Notifications\SendResetPasswordCodeNotification;
use App\Notifications\SendVerifyCodeWithQueueNotification;
use Illuminate\Auth\Passwords\CanResetPassword as PasswordsCanResetPassword;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail, CanResetPassword
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'users';
    protected $fillable = [
        'name',
        'email',
        'password',
        'remember_token',
        'email_verified_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function sendEmailVerificationCodeNotification($user_id)
    {
        $this->notify(new SendVerifyCodeWithQueueNotification($user_id));
    }
    public function emailActivationCode()
    {
        return $this->hasOne(EmailActivationCode::class, 'user_id', 'id');
    }

    public function passwordReset()
    {
        return $this->hasOne(PasswordReset::class, 'user_id', 'id');
    }

    public function sendPasswordResetNotification($user_id)
    {
        $this->notify(new SendResetPasswordCodeNotification($user_id));
    }
}