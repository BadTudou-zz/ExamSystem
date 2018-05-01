<?php

namespace App\Http\Controllers\API;

use App\QuestionType;
use App\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


use App\Exam;
use App\User;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ExcelController extends Controller
{
        public function import () {

            $filePath = $this->upload($_FILES,"questions");
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

        public function importStudent() {
            $filePath = $this->upload($_FILES,"student");

//            $filePath = public_path() . DIRECTORY_SEPARATOR ."students" . "/" .  "student.xlsx";
            Excel::load($filePath, function($reader) {
                $roleid = Role::where("name","student")->first()->id;
                $reader = $reader->getSheet(0);
                //获取表中的数据
                $data = $reader->toArray();
                $roleUser = [];
                for ($i = 1;$i<count($data);$i ++){
                    $user = new User();
                    $user->name = $data[$i][0];
                    $user->email = $data[$i][1];
                    $user->number = $data[$i][2];
                    $user->phone = $data[$i][3];
                    $user->qq  = $data[$i][4];
                    $user->password  = bcrypt($data[$i][5]);
                    $user->created_at = (date('Y-m-d H:i:s', time()));
                    $user->updated_at = (date('Y-m-d H:i:s', time()));
                    $user->save();
                    $roleUser[$i]["user_id"] = $user->id;
                    $roleUser[$i]['role_id'] = $roleid;
                }
                DB::table("role_user")->insert(
                    $roleUser
                );

            });
        }
    public function importTeacher() {
        $filePath = $this->upload($_FILES,"teacher");

//            $filePath = public_path() . DIRECTORY_SEPARATOR ."students" . "/" .  "student.xlsx";
        Excel::load($filePath, function($reader) {
            $roleid = Role::where("name","teacher")->first()->id;
            $reader = $reader->getSheet(0);
            //获取表中的数据
            $data = $reader->toArray();
            $roleUser = [];
            for ($i = 1;$i<count($data);$i ++){
                $user = new User();
                $user->name = $data[$i][0];
                $user->email = $data[$i][1];
                $user->number = $data[$i][2];
                $user->phone = $data[$i][3];
                $user->qq  = $data[$i][4];
                $user->password  = bcrypt($data[$i][5]);
                $user->created_at = (date('Y-m-d H:i:s', time()));
                $user->updated_at = (date('Y-m-d H:i:s', time()));
                $user->save();
                $roleUser[$i]["user_id"] = $user->id;
                $roleUser[$i]['role_id'] = $roleid;
            }
            DB::table("role_user")->insert(
                $roleUser
            );

        });
    }


        protected  function upload ($files,$folders){
            // 把当前上传文档的时间精确到秒作为文件名重新赋值给上传文件作为它的新的文件名
            $date = date('Y-m-dHis',time());
            // 以.来截取文件的后缀名
            $uptype = explode(".", $files["document"]["name"]);
            // 然后把当前时间加上后缀名就是该文档的新名称。
            $album_picture_name = $date.".".$uptype[1];
            // 给上传的文档重新命名
            $files["document"]["name"] = $album_picture_name;
            //定义上传文件存储位置
            $path =  public_path() . DIRECTORY_SEPARATOR .$folders . DIRECTORY_SEPARATOR .  $files["document"]["name"];

            // 移动文件到自己建的文件夹下
            if(move_uploaded_file($files["document"]["tmp_name"], $path)){

                return $path;
            }
            return false;
        }



}
