<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Captcha extends Model
{
    public const PURPOSE_REGISTER   = 'REGISTER';
    public const PURPOSE_LOGIN      = 'LOGIN';

    protected $fillable = [
        'user_id', 'purpose', 'captcha', 'expires_at',
    ];
}
