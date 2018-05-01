<?php

namespace App\Http\Controllers\API;

use App\Models\Comment;
use App\Models\Discuss;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DiscussController extends Controller
{

    public function publishDiscuss(Request $request) {
        $lid = $request->input('l_id');
        $title = $request->input('title');
        $content = $request->input('content');
        $userid = $request->input('userid');

        $discuss = new Discuss();
        $discuss->l_id = $lid;
        $discuss->title = $title;
        $discuss->content = $content;
        $discuss->userid = $userid;
        if ($discuss->save()){
            return json_encode(["status"=>0,"message"=>"发布讨论主题成功..."]);
        }

    }


    public function updateDiscuss(Request $request) {
        $id = $request->input('id');
        $title = $request->input('title');
        $content = $request->input('content');
        $lid = $request->input('l_id');
        $discuss = Discuss::find($id);

        $discuss->l_id = $lid;
        $discuss->title = $title;
        $discuss->content = $content;

        if ($discuss->save()){
            return json_encode(["status"=>0,"message"=>"修改讨论主题成功..."]);
        }

    }


    public function deleteDiscuss(Request $request) {
        $id = $request->input('id');

        $discuss = Discuss::find($id);
        $discuss->delete();

        Comment::where("discuss_id",$id)->delete();
        return json_encode(["status"=>0,"message"=>"删除主题和主题下的回复成功..."]);
    }


    public function selectForUserid (Request $request) {
        $userid = $request->input("userid");

        $discuss = new Discuss();

        $data = $discuss->where("userid",$userid)->get()->toJson();
        return $data;
    }

    public function selectForLid (Request $request) {
        $lid = $request->input("l_id");

        $discuss = new Discuss();

        $data = $discuss->where("l_id",$lid)->get()->toJson();
        return $data;
    }

    public function selectAll(Request $request) {
        $discuss = new Discuss();
        $data = $discuss->get()->toJson();
        return $data;
    }





}
