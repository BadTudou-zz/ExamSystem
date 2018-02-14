<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Exam\Index as IndexExam;
use App\Http\Requests\Exam\Store as StoreExam;
use App\Http\Requests\Exam\Update as UpdateExam;
use App\Http\Requests\Exam\Show as ShowExam;
use App\Http\Requests\Exam\Destroy as DestroyExam;
use App\Http\Requests\Exam\Answer as AnswerExam;
use App\Http\Requests\Exam\AddUsers as AddUsersToExam;
use App\Http\Requests\Exam\DeleteUsers as DeleteUsersFromExam;
use App\Http\Resources\ExamCollection;
use App\Http\Resources\ExamResource;
use App\Http\Resources\UserCollection;
use Illuminate\Support\Facades\Auth;
use App\Exam;
use App\User;

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

    public function users($id)
    {
        return new UserCollection(Exam::find($id)->users()->paginate());
    }

    public function addUsers(AddUsersToExam $request, $id)
    {
        $exam = Exam::findOrFail($id);
        $users = User::find($request->users);
        $exam->users()->syncWithoutDetaching($users);
    }

    public function deleteUsers(DeleteUsersFromExam $request, $id)
    {
        $exam = Exam::findOrFail($id);
        $users = User::find($request->users);
        $exam->users()->detach($users);
    }

    public function answer(AnswerExam $request, $id)
    {
        $user = Auth::user();
        $exam = $user->exams->whereHas('exam_id', $id)
            ->get();
        $exam->update(['answers' => '12345']);
        return $exam;
    }
}
