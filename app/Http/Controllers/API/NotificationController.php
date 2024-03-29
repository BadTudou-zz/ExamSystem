<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Http\Resources\SystemNotificationResource;
use App\Http\Resources\SystemNotificationCollection;
use App\Http\Requests\Notification\Index as IndexNotification;
use App\Http\Requests\Notification\Store as StoreNotification;
use App\Http\Requests\Notification\Destroy as DestroyNotification;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Notification;
use App\Notifications\SystemNotification;

class NotificationController extends Controller
{
    public function index(IndexNotification $request)
    {
        return SystemNotificationResource::collection( Notification::where('type', SystemNotification::class)->paginate());
    }

    public function show(Request $request, $id)
    {
        return new SystemNotificationResource(Notification::find($id));
    }

    public function store(StoreNotification $request)
    {
        Auth::user()->notify(new SystemNotification((object)['to' => 0, 'data' => $request->data]));
    }

    public function destroy(DestroyNotification $request, $id)
    {
        Notification::where('type', SystemNotification::class)
            ->where('id', $id)
            ->first()
            ->delete();
    }

}