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

        $user  = Auth::user();

        if (!($user->hasRole('teacher') || $user->hasRole("admin"))) {
            return response()->json(['message' => 'unauthorized '],401);
        }

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

        $user  = Auth::user();

        if (!($user->hasRole('teacher') || $user->hasRole("admin"))) {
            return response()->json(['message' => 'unauthorized '],401);
        }

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

        $user  = Auth::user();

        if (!($user->hasRole('teacher') || $user->hasRole("admin"))) {
            return response()->json(['message' => 'unauthorized '],401);
        }

        $id = $request->input('id');

        $discuss = Discuss::find($id);
        $discuss->delete();

        Comment::where("discuss_id",$id)->delete();
        return json_encode(["status"=>0,"message"=>"删除主题和主题下的回复成功..."]);
    }


    public function selectDiscussForUserid (Request $request) {
        $user  = Auth::user();

        if (!($user->hasRole('teacher') || $user->hasRole("admin"))) {
            return response()->json(['message' => 'unauthorized '],401);
        }

        $userid = $request->input("userid");

        $discuss = new Discuss();

        $data = $discuss->where("userid",$userid)->get()->toJson();
        return $data;
    }

    public function selectDiscussForLid (Request $request) {

        $user  = Auth::user();

        if (!($user->hasRole('teacher') || $user->hasRole("admin"))) {
            return response()->json(['message' => 'unauthorized '],401);
        }

        $lid = $request->input("l_id");

        $discuss = new Discuss();

        $data = $discuss->where("l_id",$lid)->get()->toJson();
        return $data;
    }

    public function selectDiscussAll(Request $request) {
        $user  = Auth::user();

        if (!($user->hasRole("admin"))) {
            return response()->json(['message' => 'unauthorized '],401);
        }
        $discuss = new Discuss();
        $data = $discuss->get()->toJson();
        return $data;
    }

    public function selectDiscussAndReply(Request $request) {
        $user  = Auth::user();

        if (!($user->hasRole("admin") || $user->hasRole("teacher") || $user->hasRole("student")) ) {
            return response()->json(['message' => 'unauthorized '],401);
        }
        $discuss_id = $request->input("discuss_id");
        $discuss = Discuss::find($discuss_id);
        $discuss->replys;
        return $discuss->toJson();

    }

    public function replyDiscuss(Request $request) {
        $user  = Auth::user();

        if (!($user->hasRole("admin") || $user->hasRole("teacher") || $user->hasRole("student")) ) {
            return response()->json(['message' => 'unauthorized '],401);
        }
         $userid = $request->input("userid");
         $discuss_id = $request->input("discuss_id");
         $body = $request->input("body");


        $comment = new Comment();
        $comment->discuss_id = $discuss_id;
        $comment->userid = $userid;
        $comment->body = $body;
        if ($comment->save()){
            return json_encode(["status"=>0,"message"=>"回复主题主题成功..."]);
        }

    }

    public function deleteReply(Request $request) {
        $user  = Auth::user();

        if (!($user->hasRole("admin") || $user->hasRole("teacher") || $user->hasRole("student")) ) {
            return response()->json(['message' => 'unauthorized '],401);
        }
        $id = $request->input("id");
        $commnet = Comment::find($id);
        $commnet->delete();
        return json_encode(["status"=>0,"message"=>"删除回复成功..."]);
    }

    public function selectReplyForUserid(Request $request) {
        $user  = Auth::user();

        if (!($user->hasRole("admin")) ) {
            return response()->json(['message' => 'unauthorized '],401);
        }
        $userid = $request->input("userid");
        $comments = new Comment();
        $data = $comments->where("user_id",$userid)->get()->toJson();
        return $data;
    }
    public function selectReplyForLid(Request $request) {
        $user  = Auth::user();

        if (!($user->hasRole("admin") || $user->hasRole("teacher") || $user->hasRole("student")) ) {
            return response()->json(['message' => 'unauthorized '],401);
        }
        $discuss_id = $request->input("discuss_id");
        $comments = new Comment();
        $data = $comments->where("discuss_id",$discuss_id)->get()->toJson();
        return $data;
    }

    public function selectReplyAll() {
        $user  = Auth::user();

        if (!($user->hasRole("admin")) ) {
            return response()->json(['message' => 'unauthorized '],401);
        }
        $comment = new Comment();
        $data = $comment->get()->toJson();
        return $data;
    }

}
