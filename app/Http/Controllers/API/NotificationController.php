<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Http\Resources\SystemNotificationResource;
use App\Http\Resources\SystemNotificationCollection;

use Illuminate\Support\Facades\Auth;
use Validator;
use App\Notification;
use App\Notifications\SystemNotification;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        return new SystemNotificationCollection( Notification::where('type', SystemNotification::class)->paginate());
    }

    public function show(Request $request, $id)
    {
        return new SystemNotificationResource(Notification::find($id));
    }

    public function store(Request $request)
    {
        Auth::user()->notify(new SystemNotification((object)['data' => $request->data]));
    }

    public function destroy(Request $request, $id)
    {
        $user = Auth::user();
        $user->notifications()->where('type', SystemNotification::class)
            ->where('notifiable_id', $user->id)
            ->where('id', $id)
            ->first()
            ->delete();
    }

    public function notifications(Request $request)
    {
        return SystemNotificationResource::collection( Auth::user()->notifications()->where('type', SystemNotification::class)->paginate());
    }
}