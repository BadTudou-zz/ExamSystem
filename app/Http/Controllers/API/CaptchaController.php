<?php

namespace App\Http\Controllers\API;

use Gregwar\Captcha\CaptchaBuilder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Captcha\Store as StoreCaptcha;
use Validator;
use Response;
use App\Captcha;
use Carbon\Carbon;


class CaptchaController extends Controller
{
  
    public function store(StoreCaptcha $request)
    {
        $builder = new CaptchaBuilder;
        $builder->build();
        $captcha = Captcha::create(['user_id' => 0, 'purpose' => $request->get('purpose'),'captcha' => $builder->getPhrase(), 'expires_at' => Carbon::now()->addMinutes(3)]);
        return $response = Response::make($builder->output())->header('Content-Type', 'image/png');
    }
}