<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\QuestionType;
use App\Http\Resources\QuestionResource;
use App\Http\Resources\QuestionTypeResource;
use App\Http\Requests\QuestionType\Index as IndexQuestionType;
use App\Http\Requests\QuestionType\Show as ShowQuestionType;
use App\Http\Requests\QuestionType\Store as StoreQuestionType;
use App\Http\Requests\QuestionType\Update as UpdateQuestionType;
use App\Http\Requests\QuestionType\Destroy as DestroyQuestionType;
use App\Http\Requests\QuestionType\IndexQuestion as QuestionIndexQuestionType;

class QuestionTypeController extends Controller
{
    public function index(IndexQuestionType $request)
    {
        return QuestionTypeResource::collection(QuestionType::paginate());
    }

    public function show(ShowQuestionType $request, $id)
    {
        return new QuestionTypeResource(QuestionType::findOrFail($id));
    }

    public function store(StoreQuestionType $request)
    {
        $questionType = QuestionType::create($request->all());
        return new QuestionTypeResource($questionType);
    }

    public function update(UpdateQuestionType $request, $id)
    {
        $questionType = QuestionType::findOrFail($id);
        $questionType->update($request->all());
        return new QuestionTypeResource($questionType);
    }

    public function destroy(DestroyQuestionType $request, $id)
    {
        QuestionType::findOrFail($id)->delete();
    }

    public function questions(QuestionIndexQuestionType $request, $id)
    {
        $questionType = QuestionType::findOrFail($id);
        return $questionType->Questions()->paginate();
    }
}
