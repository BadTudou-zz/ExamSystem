<?php

namespace App\Http\Controllers;

use App\QuestionType;
use App\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;
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

    public function webrtc(Request $request){

        if(isset($_POST['postdata'])){
            $filename = public_path() . DIRECTORY_SEPARATOR . 'video' . DIRECTORY_SEPARATOR . "123.png";

            $myfile = fopen($filename, "w");
            $_POST['postdata'] = str_replace('data:image/png;base64,', '', $_POST['postdata']);
            file_put_contents($filename, base64_decode($_POST['postdata']));
            fclose($myfile);
        }

    }
    public function test(Request $request)
    {



    }
}
