<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Notification;
use App\Notifications\ApplicationNotification;
use App\Http\Resources\ApplicationCollection;
use App\Http\Resources\ApplicationResource;
class ApplicationController extends Controller
{
    public function index()
    {
        return new ApplicationCollection( Notification::where('type', ApplicationNotification::class)->paginate());
    }

    public function store(Request $request)
    {
        Auth::user()->notify(new ApplicationNotification((object)['id' => $request->to, 'action' => $request->action, 'resource_id' => $request->resource_id, 'resource_type' => $request->resource_type, 'data' => $request->data]));
    }

    public function show(Request $request, $id)
    {
        return new ApplicationResource(Notification::find($id));
    }

    public function destroy(Request $request, $id)
    {
        $user = Auth::user();
        $user->notifications()->where('type', ApplicationNotification::class)
            ->where('notifiable_id', $user->id)
            ->where('id', $id)
            ->first()
            ->delete();
    }
}
