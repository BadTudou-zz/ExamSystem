<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Exam\Index as IndexExam;
use App\Http\Requests\Exam\Store as StoreExam;
use App\Http\Requests\Exam\Update as UpdateExam;
use App\Http\Requests\Exam\Show as ShowExam;
use App\Http\Requests\Exam\Destroy as DestroyExam;
use App\Http\Resources\ExamCollection;
use App\Http\Resources\ExamResource;
use Illuminate\Support\Facades\Auth;
use App\Exam;

class ExamController extends Controller
{
    public function index(IndexExam $request)
    {
    	return new ExamCollection(Exam::paginate());
    }

    public function show(ShowExam $request, $id)
    {
    	return new ExamResource(Exam::findOrFail($id));
    }

    public function store(StoreExam $request)
    {
    	$request->request->add(
            [
                'creator_id' => Auth::user()->id
            ]
        );
        $exam = Exam::create($request->all());
        return $exam;
    }

    public function update(UpdateExam $request, $id)
    {
        $exam = Exam::findOrFail($id);
        $exam->update($request->all());
        return new ExamResource($exam);
    }

    public function destroy(DestroyExam $request, $id)
    {
        Exam::findOrFail($id)->delete();
    }
}
