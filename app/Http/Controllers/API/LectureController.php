<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\LectureCollection;
use App\Http\Resources\LectureResource;
use App\Http\Requests\IndexLecture;
use App\Http\Requests\ShowLecture;
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

    public function update(UpdateLecture $request, $id)
    {
        $lecture = Lecture::find($id);
        $lecture->update($request->all());
        return new LectureResource($lecture);
    }

    public function destroy(DestroyLecture $request, $id)
    {
        Lecture::find($id)->delete();
    }
}