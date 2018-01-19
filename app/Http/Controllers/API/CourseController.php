<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CourseCollection;
use App\Http\Resources\CourseResource;
use App\Http\Requests\IndexCourse;
use App\Http\Requests\ShowCourse;
use App\Http\Requests\StoreCourse;
use App\Http\Requests\UpdateCourse;
use App\Http\Requests\DestroyCourse;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Course;


class CourseController extends Controller
{
    public function index(IndexCourse $request)
    {
         return new CourseCollection(Course::paginate());
    }

    public function show(ShowCourse $request, $id)
    {
        return new CourseResource(Course::find($id));
    }

    public function store(StoreCourse $request)
    {   
        $request->request->add(
            [
                'creator_id' => Auth::user()->id,
                'max' => $request->get('max', '0'),
                'current' => 1
            ]
        );
        $course = Course::create($request->all());
        return $course;
    }

    public function update(UpdateCourse $request, $id)
    {
        $course = Course::find($id);
        $course->update($request->all());
        return new CourseResource($course);
    }

    public function destroy(DestroyCourse $request, $id)
    {
        Course::find($id)->delete();
    }
}