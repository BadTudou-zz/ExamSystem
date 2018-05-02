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
use App\Http\Requests\Exam\Begin as BeginExam;
use App\Http\Requests\Exam\AddUsers as AddUsersToExam;
use App\Http\Requests\Exam\DeleteUsers as DeleteUsersFromExam;
use App\Http\Resources\ExamCollection;
use App\Http\Resources\ExamResource;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserExamResource;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Jobs\CorrecExam;
use App\Util\OrmUtil;

use App\Exam;
use App\User;

class ExamController extends Controller
{
    public function index(IndexExam $request)
    {
        $type = $request->get('type', null);
        if ($type == 'PRACTICE') {
            return ExamResource::collection(Exam::where('type', 'PRACTICE')->paginate());
        } 

        if ($type == 'OFFICIAL') {
            return ExamResource::collection(Exam::where('type', 'OFFICIAL')->paginate());
        } 

    	return  ExamResource::collection(Exam::paginate());
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
        $exam = $user->exams()->where('exam_id', $id)->first();
        if (!$exam->begin_at || !$exam->start_at) {
            return response()->json(['error'=>'考试还未开始，请耐心等待！'], 400);
        }

        if ($exam->finish_at) {
            return response()->json(['error'=>'考试已经结束，不能提交答案！'], 400);
        }
        $answersSaved = json_decode($exam->pivot->answers);
        $answersNew = json_decode($request->answers);
        $answers = array_merge((array)$answersSaved, (array)$answersNew);
        $exam->pivot->answers = json_encode($answers);
        $exam->pivot->touch();
        $exam->pivot->save();
    }

    public function start(UpdateExam $request, $id)
    {
         $exam = Exam::findOrFail($id);
         if (!$exam->start_at) {
            $exam->update(['start_at' => Carbon::now()]);
         } else {
            return response()->json(['error'=>'考试已经开始，不能重复开始考试！'], 400);
         }
    }

    public function stop(UpdateExam $request, $id)
    {
        $exam = Exam::findOrFail($id);
        if (!$exam->finish_at) {
            $exam->update(['finish_at' => Carbon::now()]);
        } else {
            return response()->json(['error'=>'考试已经结束，不能重复结束考试！'], 400);
        }

    }

    //用户开始考试
    public function begin(BeginExam $request, $id)
    {
        $user = Auth::user();
        $exam = $user->exams()->where('exam_id', $id)->first();

        if (!$exam->start_at) {
            return response()->json(['error'=>'考试还未开始，请耐心等待！'], 400);
        }

        if ($exam->finish_at) {
            return response()->json(['error'=>'考试已经结束，不能参加！'], 400);
        }

        if (!$exam->pivot->begin_at) {
            $exam->pivot->begin_at = Carbon::now();
            $exam->pivot->touch();
            $exam->pivot->save();
        } else {
            return response()->json(['error'=>'你已经开始考试，不能重复提交！'], 400);
        }
    }

    //用户结束考试
    public function finish(BeginExam $request, $id)
    {
        $user = Auth::user();
        $exam = $user->exams()->where('exam_id', $id)->first();

        if (!$exam->begin_at) {
            return response()->json(['error'=>'考试还未开始，不能结束！'], 400);
        }

        if ($exam->finish_at) {
            return response()->json(['error'=>'考试已经结束，不能重复结束！'], 400);
        }

        if (!$exam->pivot->finish_at) {
            $exam->pivot->finish_at = Carbon::now();
            $exam->pivot->touch();
            $exam->pivot->save();
        } else {
            return response()->json(['error'=>'你已经完成考试，不能重复提交！'], 400);
        }
        
    }

    //自动批改本次考试的所有试卷
    public function correct(UpdateExam $request, $id)
    {
        $exam = Exam::find($id);

        if (!$exam->begin_at) {
            return response()->json(['error'=>'考试未开始，不能批改！'], 400);
        }

        if (!$exam->finish_at) {
            return response()->json(['error'=>'考试未结束，不能批改！'], 400);
        }

        CorrecExam::dispatch($exam);
    }

    //查看分数
    public function score(BeginExam $request, $id)
    {
        $user = Auth::user();
        $exam = $user->exams()->where('exam_id', $id)->first();

        if (!$exam->begin_at) {
            return response()->json(['error'=>'考试未开始，不能查看！'], 400);
        }

        if (!$exam->finish_at) {
            return response()->json(['error'=>'考试未结束，不能查看！'], 400);
        }
       return response($exam->pivot);
    }

    //查看全部分数
    public function scores(UpdateExam $request, $id)
    {
        $exam = Exam::find($id);

        if (!$exam->begin_at) {
            return response()->json(['error'=>'考试未开始，不能查看！'], 400);
        }

        if (!$exam->finish_at) {
            return response()->json(['error'=>'考试未结束，不能查看！'], 400);
        }
        $scores = $exam->users()->paginate();
        return UserExamResource::collection($scores);
    }
}
