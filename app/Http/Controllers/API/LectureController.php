<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\LectureCollection;
use App\Http\Resources\LectureResource;
use App\Http\Requests\IndexLecture;
use App\Http\Requests\ShowLecture;
use App\Http\Requests\StoreLecture;
use App\Http\Requests\UpdateLecture;
use App\Http\Requests\DestroyLecture;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Lecture;


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
                'allowable_organization_ids' => implode(',', $request->get('allowable_organization_ids')),
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
                'allowable_organization_ids' => implode(',', $request->get('allowable_organization_ids')),
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
}