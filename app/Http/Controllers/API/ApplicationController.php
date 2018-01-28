<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Notification;
use App\Notifications\ApplicationNotification;
use App\Http\Resources\ApplicationCollection;
use App\Http\Resources\ApplicationResource;
use App\Http\Requests\Application\Index as IndexApplication;
use App\Http\Requests\Application\Show as ShowApplication;
use App\Http\Requests\Application\Store as StoreApplication;
use App\Http\Requests\Application\Destroy as DestroyApplication;
use App\Http\Requests\Application\Accept as AcceptApplication;
use App\Http\Requests\Application\Reject as RejectApplication;
use App\Organization;
use App\Lecture;
use App\User;
class ApplicationController extends Controller
{
    public function index(IndexApplication $request)
    {
        return  ApplicationResource::collection( Notification::where('type', ApplicationNotification::class)->paginate());
    }

    public function store(StoreApplication $request)
    {
        return Auth::user()->notify(new ApplicationNotification((object)['id' => $request->to, 'action' => $request->action, 'resource_id' => $request->resource_id, 'resource_type' => $request->resource_type, 'data' => $request->data]));
    }

    public function show(ShowApplication $request, $id)
    {
        return new ApplicationResource(Notification::find($id));
    }

    public function destroy(DestroyApplication $request, $id)
    {
        $user = Auth::user();
        $user->notifications()->where('type', ApplicationNotification::class)
            ->where('notifiable_id', $user->id)
            ->where('id', $id)
            ->first()
            ->delete();
    }

    public function accept(AcceptApplication $request, $id)
    {
        $user = Auth::user();
        $application = Notification::find($id);
        return $this->acceptApplication($application);
        return new ApplicationResource($application);
    }

    public function reject(RejectApplication $request, $id)
    {
        
    }

    protected function acceptApplication($application)
    {
        $data = json_decode($application->data);

        switch ($data->resource_type) {
            case 'Organization':
                return $this->acceptOrganizationApplication($application);
                break;

            case 'Lecture':
                return $this->acceptLectureApplication($application);
                break;
            
            default:
                # code...
                break;
        }
        return "from:{$application->notifiable_id}\n to:{$data->notifiable_id}\n {$data->resource_type}.{$data->resource_id}.{$data->action}.{$application->notifiable_id}";
    }

    public function acceptOrganizationApplication($application)
    {
        $data = json_decode($application->data);

        $user = Auth::user();
        $organization = Organization::findOrFail($data->resource_id);
        // 检测当前用户的权限
        if ($organization->creator_id != $user->id) {
            return response()->json(['error'=>'This action is unauthorized.'], 403);
        }
        
        // 将用户加入组织
        $users = User::findOrFail($application->notifiable_id);
        $organization->users()->syncWithoutDetaching($users);
        $application->delete();
    }

    public function acceptLectureApplication($application)
    {
        $data = json_decode($application->data);

        $user = Auth::user();
        $lectrue = Lecture::findOrFail($data->resource_id);
        // 检测当前用户的权限
        if ($lectrue->user_id != $user->id) {
            return response()->json(['error'=>'This action is unauthorized.'], 403);
        }
        
        // 将用户加入组织
        $users = User::findOrFail($application->notifiable_id);
        $lectrue->users()->syncWithoutDetaching($users);
        $application->delete();
    }
}
