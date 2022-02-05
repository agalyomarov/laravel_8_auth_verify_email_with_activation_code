<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailActivationCode extends Model
{
    use HasFactory;
    protected $table = 'email_activation_codes';
    protected $guarded = [];
}