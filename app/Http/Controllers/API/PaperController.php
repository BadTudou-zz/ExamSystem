<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Paper\Index as IndexPaper;
use App\Http\Requests\Paper\Show as ShowPaper;
use App\Http\Requests\Paper\Store as StorePaper;
use App\Http\Requests\Paper\Update as UpdatePaper;
use App\Http\Requests\Paper\Destroy as DestroyPaper;
use App\Http\Requests\Paper\PaperMakeQuestions;
use App\Http\Resources\PaperResource;
use App\Http\Resources\PaperCollection;
use App\Http\Resources\QuestionResource;
use App\Http\Resources\QuestionCollection;
use App\Paper;
use App\Util\OrmUtil;
use Validator;
use App\Jobs\MakeQuestionsForPaper;

class PaperController extends Controller
{
    public function index(IndexPaper $request)
    {
        return new PaperCollection(Paper::paginate());
    }

    public function store(StorePaper $request)
    {
        $request->request->add(
            [
                'creator_id' => Auth::user()->id
            ]
        );
        if ($request->has('sections')) {
                $request['sections'] = implode(",", $request->sections);
        }
        $paper = Paper::create($request->all());
        return new PaperResource($paper);
    }

    public function show(ShowPaper $request, $id)
    {
        return new PaperResource(Paper::findOrFail($id));
    }


    public function questions(ShowPaper $request, $id)
    {
        return  QuestionResource::collection(OrmUtil::paginate(Paper::findOrFail($id)->questions()));
    }

    public function scores(ShowPaper $request, $id)
    {
        return response()->json(['data'=> Paper::findOrFail($id)->scores()]);
    }

    public function update(UpdatePaper $request, $id)
    {
        $paper = Paper::findOrFail($id);
        if ($request->has('sections')) {
                $request['sections'] = implode(",", $request->sections);
        }
        $paper->update($request->all());
        return new PaperResource($paper);
    }

    public function destroy(DestroyPaper $request, $id)
    {
        Paper::findOrFail($id)->delete();
    }

    public function maker(PaperMakeQuestions $request, $id)
    {
        $data = $request->only(['id', 'number', 'types']);
        MakeQuestionsForPaper::dispatch(array_merge($data, ['id' => $id]));
    }
}