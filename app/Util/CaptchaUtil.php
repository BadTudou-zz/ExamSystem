<?php

namespace App\Util;
use App\Captcha;
use Carbon\Carbon;

class CaptchaUtil
{
    public static function check($user, $purpose, $captcha)
    {
        if ($captcha = Captcha::where(
            [
                'user_id' => $user,
                'purpose' => $purpose,
                'captcha' => $captcha
            ])
            ->where('expires_at', '>=', Carbon::now())
            ->first()
        ){
            $captcha->delete();
            return true;
        }

        return false;
    }
}
