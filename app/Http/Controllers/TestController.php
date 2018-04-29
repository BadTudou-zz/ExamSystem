<?php

namespace App\Http\Controllers;

use App\QuestionType;
use App\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

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



        $filePath = public_path() . DIRECTORY_SEPARATOR . 'video' . DIRECTORY_SEPARATOR . "123.xlsx";
//        $filePath = 'storage/exports/'.iconv('UTF-8', 'GBK', '学生成绩').'.xls';
        Excel::load($filePath, function($reader) {
            $allType = QuestionType::get(["name","id"])->toArray();
            $newType = [];
            foreach ($allType as $value){
                $newType[$value["id"]] = $value['name'];
            }

            $reader = $reader->getSheet(0);
            //获取表中的数据
            $data = $reader->toArray();
            $questions = [];
           for ($i = 1;$i<count($data);$i ++){
                $questions[$i]['type_id'] = array_search($data[$i][0], $newType);
                $questions[$i]['tags'] = $data[$i][1];
                $questions[$i]['level_type'] = $data[$i][2];
                $questions[$i]['title'] = $data[$i][3];
                $questions[$i]['body'] = $data[$i][4];
                $questions[$i]['answer']  = $data[$i][5];
                $questions[$i]['answer_comment']  = $data[$i][6];
               $questions[$i]['created_at'] = (date('Y-m-d H:i:s', time()));
               $questions[$i]['updated_at'] = (date('Y-m-d H:i:s', time()));
           }
           DB::table("questions")->insert(
               $questions
           );

        });
    }
}
