<?php

namespace App\Http\Controllers;

use App\Video;
use Illuminate\Http\Request;

class TestController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('test');
    }
    public function test()
    {
        $test = new \App\models\Video();
    }
}
