<?php

namespace App\Http\Controllers\API;

use App\Models\Video;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class VideoController extends Controller
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
        $videoName = $request->input('videoName');
        $kp = $request->input('kp');
        $video = new Video();
        $video->userid = $userid;
        $video->cid = $cid;
        $video->video_name = $videoName;
        $video->kp = $kp;
        $video->url = public_path() . DIRECTORY_SEPARATOR . 'video' . DIRECTORY_SEPARATOR . $filename;
        $video->save();
    }

    public function selectForUserid(Request $request) {
        $userid = $request->input('userid');
        $video = new Video();
        $data = $video->where("userid",$userid)->get()->toJson();
        return $data;
    }
    public function selectForCid(Request $request) {
        $cid = $request->input('cid');
        $video = new Video();
        $data = $video->where("cid",$cid)->get()->toJson();
        return $data;
    }
    public function delete(Request $request) {
        $id = $request->input('id');
        $video = Video::find($id);
        if ($video->delete()){
            if(file_exists ($video->url)){
                unlink($video->url);
                return json_encode(["status"=>0,"message"=>"删除成功！"]);
            }
            return json_encode(["status"=>0,"message"=>"删除成功！"]);
        }else {
            return json_encode(["status"=>1,"message"=>"删除失败！"]);
        }
    }

    public function update(Request $request) {
        $id = $request->input('id');
        $videoName = $request->input('videoName');
        $kp = $request->input('kp');
        $video = Video::find($id);
        $video->video_name = $videoName;
        $video->kp = $kp;
        if ($video->save()) {
            return json_encode(["status"=>0,"message"=>"删除成功！"]);
        }
    }
}
