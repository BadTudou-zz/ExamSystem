<?php

namespace App\Http\Controllers\API;

use App\Models\Document;
use App\Models\Video;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


class DocumentController extends Controller
{
    public function uploadDoc () {
        /*
        接收文件并合并
        */

        // 获取文件名
        $filename = $_GET['filename'];
        echo $filename;
        // 第一次如果文件不存在就把传过来的二进制数据移动到新的文件里面
        $path = public_path() . DIRECTORY_SEPARATOR . 'document' . DIRECTORY_SEPARATOR . $filename;

        if (!file_exists($path)) {
            move_uploaded_file($_FILES['part']['tmp_name'],$path);
        } else {
            // 第二次文件已经存在了，那就把二进制文件追加的形式追加到文件内。
            file_put_contents($path ,file_get_contents($_FILES['part']['tmp_name']),FILE_APPEND);
        }
    }

    public function insert(Request $request){

        $user  = Auth::user();

        if (!($user->hasRole('teacher') || $user->hasRole("admin"))) {
            return response()->json(['message' => 'unauthorized '],401);
        }

        $userid = $request->input('userid');
        $cid = $request->input('cid');
        $filename = $request->input('filename');
        $docName = $request->input('docName');
        $kp = $request->input('kp');
        $doc = new Document();
        $doc->userid = $userid;
        $doc->cid = $cid;
        $doc->doc_name = $docName;
        $doc->kp = $kp;
        $doc->url = public_path() . DIRECTORY_SEPARATOR . 'document' . DIRECTORY_SEPARATOR . $filename;
        $doc->save();
    }

    public function selectForUserid(Request $request) {

        $user  = Auth::user();

        if (!($user->hasRole('teacher') || $user->hasRole("admin"))) {
            return response()->json(['message' => 'unauthorized '],401);
        }

        $userid = $request->input('userid');
        $doc = new Document();
        $data = $doc->where("userid",$userid)->get()->toJson();
        return $data;
    }
    public function selectForCid(Request $request) {

        $user  = Auth::user();

        if (!($user->hasRole('teacher') || $user->hasRole("admin"))) {
            return response()->json(['message' => 'unauthorized '],401);
        }

        $cid = $request->input('cid');
        $doc = new Document();
        $data = $doc->where("cid",$cid)->get()->toJson();
        return $data;
    }
    public function delete(Request $request) {

        $user  = Auth::user();

        if (!($user->hasRole('teacher') || $user->hasRole("admin"))) {
            return response()->json(['message' => 'unauthorized '],401);
        }


        $id = $request->input('id');
        $doc = Document::find($id);
        if ($doc->delete()){
            if(file_exists ($doc->url)){
                unlink($doc->url);
                return json_encode(["status"=>0,"message"=>"删除成功！"]);
            }
            return json_encode(["status"=>0,"message"=>"删除成功！"]);
        }else {
            return json_encode(["status"=>1,"message"=>"删除失败！"]);
        }
    }

    public function update(Request $request) {

        $user  = Auth::user();

        if (!($user->hasRole('teacher') || $user->hasRole("admin"))) {
            return response()->json(['message' => 'unauthorized '],401);
        }


        $id = $request->input('id');
        $docName = $request->input('docName');
        $kp = $request->input('kp');
        $doc = Document::find($id);
        $doc->doc_name = $docName;
        $doc->kp = $kp;
        if ($doc->save()) {
            return json_encode(["status"=>0,"message"=>"更新成功！"]);
        }
    }
    public function selectAll(Request $request){
        $user  = Auth::user();

        if (!$user->hasRole("admin")) {
            return response()->json(['message' => 'unauthorized '],401);
        }

        $preview = new Document();
        $data = $preview->get()->toJson();
        return $data;
    }

}
