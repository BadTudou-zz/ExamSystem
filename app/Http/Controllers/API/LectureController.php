<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\LectureCollection;
use App\Http\Resources\LectureResource;
use App\Http\Requests\Lecture\Index as IndexLecture;
use App\Http\Requests\Lecture\Show as ShowLecture;
use App\Http\Requests\Lecture\Store as StoreLecture;
use App\Http\Requests\Lecture\Update as UpdateLecture;
use App\Http\Requests\Lecture\Destroy as DestroyLecture;
use App\Http\Requests\Lecture\AddUsers as AddUsersToLecture;
use App\Http\Requests\Lecture\DeleteUsers as DeleteUsersFromLecture;
use App\Http\Resources\UserCollection;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Lecture;
use App\User;

class LectureController extends Controller
{
    public function index(IndexLecture $request)
    {
        return new LectureCollection(Lecture::paginate());
    }

    public function show(ShowLecture $request, $id)
    {
        return new LectureResource(Lecture::find($id));
    }

    public function store(StoreLecture $request)
    {   
        $request->request->add(
            [
                'user_id' => Auth::user()->id,
                'max' => $request->get('max', '0'),
                'current' => 1,
                'allowable_organization_ids' => implode(',', $request->get('allowable_organization_ids', [])),
                'allowable_user_ids' => implode(',', $request->get('allowable_user_ids', []))
            ]
        );
        $course = Lecture::create($request->all());
        return $course;
    }

    public function update(UpdateLecture $request, $id)
    {
        $lecture = Lecture::find($id);
        $request->request->add(
            [
                'max' => $request->get('max', '0'),
                'allowable_organization_ids' => implode(',', $request->get('allowable_organization_ids', [])),
                'allowable_user_ids' => implode(',', $request->get('allowable_user_ids', []))
            ]
        );
        $lecture->update($request->all());
        return new LectureResource($lecture);
    }

    public function destroy(DestroyLecture $request, $id)
    {
        Lecture::find($id)->delete();
    }

    public function users(DeleteUsersFromLecture $request, $id)
    {
        return new UserCollection(Lecture::find($id)->users()->paginate());
    }

    public function addUsers(AddUsersToLecture $request, $id)
    {
        $lecture = Lecture::find($id);
        $lecture->users()->syncWithoutDetaching($request->users);
    }

    public function deleteUsers(DeleteUsersFromLecture $request, $id)
    {
        $lecture = Lecture::find($id);
        $users = User::find($request->users);
        $lecture->users()->detach($users);
    }
}