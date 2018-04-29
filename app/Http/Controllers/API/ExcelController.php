<?php

namespace App\Http\Controllers\API;

use App\QuestionType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


use App\Exam;
use App\User;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ExcelController extends Controller
{
        public function import () {

            $filePath = $this->upload($_FILES);
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
                    $questions[$i]['level_type'] = $data[$i][1];
                    $questions[$i]['title'] = $data[$i][2];
                    $questions[$i]['body'] = $data[$i][3];
                    $questions[$i]['answer']  = $data[$i][4];
                    $questions[$i]['answer_comment']  = $data[$i][5];
                    $questions[$i]['created_at'] = (date('Y-m-d H:i:s', time()));
                    $questions[$i]['updated_at'] = (date('Y-m-d H:i:s', time()));
                }
                DB::table("questions")->insert(
                    $questions
                );

            });
        }

        protected  function upload ($files){
            // 把当前上传文档的时间精确到秒作为文件名重新赋值给上传文件作为它的新的文件名
            $date = date('Y-m-dHis',time());
            // 以.来截取文件的后缀名
            $uptype = explode(".", $files["document"]["name"]);
            // 然后把当前时间加上后缀名就是该文档的新名称。
            $album_picture_name = $date.".".$uptype[1];
            // 给上传的文档重新命名
            $files["document"]["name"] = $album_picture_name;
            //定义上传文件存储位置
            $path =  public_path() . DIRECTORY_SEPARATOR . 'questions' . DIRECTORY_SEPARATOR .  $files["document"]["name"];

            // 移动文件到自己建的文件夹下
            if(move_uploaded_file($files["document"]["tmp_name"], $path)){

                return $path;
            }
            return false;
        }
}
