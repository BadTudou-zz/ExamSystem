<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Notification as Message;
use App\Notifications\PrivateMessage;
use App\Http\Resources\PrivateMessageResource;
use App\Http\Resources\PrivateMessages;
use App\Http\Requests\Message\Index as IndexMessage;
use App\Http\Requests\Message\Show as ShowMessage;
use App\Http\Requests\Message\Store as StoreMessage;
use App\Http\Requests\Message\Destroy as DestroyMessage;
use App\Http\Resources\PrivateMessageCollection;
use Illuminate\Support\Facades\Auth;
use Validator;


class MessageController extends Controller
{
    public function index(IndexMessage $request)
    {
        return PrivateMessageResource::collection(Message::where('type', PrivateMessage::class)->paginate());
    }

    public function store(StoreMessage $request)
    {
        $fromUser =  Auth::user();
        $toUser = User::findOrFail($request->to);
        $fromUser->notify(new PrivateMessage((object)['id' => $request->to, 'from_name' => $fromUser->name, 'to_name' => $toUser->name, 'data' => $request->data]));
    }

    public function show(ShowMessage $request, $id)
    {
        return new PrivateMessageResource(Message::find($id));
    }

    public function destroy(DestroyMessage $request, $id)
    {
        $message = Message::where('type', PrivateMessage::class)->findOrFail($id);
        $message->delete();
    }

    public function read(ShowMessage $request, $id)
    {
        $message = Message::find($id);
        $message->markAsRead();
        return new PrivateMessageResource($message);
    }


}