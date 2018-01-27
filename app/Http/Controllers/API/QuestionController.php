<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\QuestionResource;
use App\Http\Resources\QuestionCollection;
use App\Http\Requests\IndexQuestion;
use App\Http\Requests\ShowQuestion;
use App\Http\Requests\StoreQuestion;
use App\Http\Requests\UpdateQuestion;
use App\Http\Requests\DestroyQuestion;
use Validator;
use App\Question;


class QuestionController extends Controller
{
    public function index(IndexQuestion $request)
    {
        return new QuestionCollection(Question::paginate());
    }

    public function show(ShowQuestion $request, $id)
    {
        return new QuestionResource(Question::findOrFail($id));
    }

    public function store(StoreQuestion $request)
    {
        $question = Question::create($request->all());
        return new QuestionResource($question);
    }

    public function update(UpdateQuestion $request, $id)
    {
        $question = Question::findOrFail($id);
        $question->update($request->all());
        return new QuestionResource($question);
    }

    public function destroy(DestroyQuestion $request, $id)
    {
        Question::findOrFail($id)->delete();
    }
}