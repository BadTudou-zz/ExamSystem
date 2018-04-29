<?php

namespace App\Http\Controllers\API;

use App\Models\Video;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class UploadFileController extends Controller
{
    public function uploadVideo () {
        /*
        接收文件并合并
        */

        // 获取文件名
        $filename = $_GET['filename'];
        echo $filename;
        // 第一次如果文件不存在就把传过来的二进制数据移动到新的文件里面
        $path = public_path() . DIRECTORY_SEPARATOR . 'video' . DIRECTORY_SEPARATOR . $filename;

        if (!file_exists($path)) {
            move_uploaded_file($_FILES['part']['tmp_name'],$path);
        } else {
            // 第二次文件已经存在了，那就把二进制文件追加的形式追加到文件内。
            file_put_contents($path ,file_get_contents($_FILES['part']['tmp_name']),FILE_APPEND);
        }
    }

    public function insert(Request $request){

        $userid = $request->input('userid');
        $cid = $request->input('cid');
        $filename = $request->input('filename');
        $video = new Video();
        $video->userid = $userid;
        $video->cid = $cid;
        $video->url = public_path() . DIRECTORY_SEPARATOR . 'video' . DIRECTORY_SEPARATOR . $filename;
        $video->save();
    }

    public function selectForUserid(Request $request) {
        $userid = $request->input('userid');
        $video = new Video();
        $data = $video->where("userid",$userid)->select();
        dd($data);
    }
}
