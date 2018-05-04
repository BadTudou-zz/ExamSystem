<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\QuestionResource;
use App\Http\Resources\QuestionCollection;
use App\Http\Requests\Question\Index as IndexQuestion;
use App\Http\Requests\Question\Show as ShowQuestion;
use App\Http\Requests\Question\Store as StoreQuestion;
use App\Http\Requests\Question\Update as UpdateQuestion;
use App\Http\Requests\Question\Destroy as DestroyQuestion;
use Validator;
use App\Question;
use App\QuestionType;


class QuestionController extends Controller
{
    public function index(IndexQuestion $request)
    {
        return new QuestionCollection(Question::SearchTags($request->get('tags'))->paginate());
    }

    public function show(ShowQuestion $request, $id)
    {
        $builder = Question::where('id', $id);
        if ($request->get('includeType') == 'yes')
            {
                $builder = $builder->with('Type');
            }
        return new QuestionResource($builder->get()->first());
    }

    public function store(StoreQuestion $request)
    {
        $request['tags'] = implode(",", $request->get('tags', []));
        $question = Question::create($request->all());
        return new QuestionResource($question);
    }

    public function update(UpdateQuestion $request, $id)
    {
        $question = Question::findOrFail($id);
        $request['tags'] = implode(",", $request->get('tags', []));
        $question->update($request->all());
        return new QuestionResource($question);
    }

    public function destroy(DestroyQuestion $request, $id)
    {
        Question::findOrFail($id)->delete();
    }
}