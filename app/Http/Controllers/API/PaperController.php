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
use App\Http\Resources\PaperResource;
use App\Http\Resources\PaperCollection;
use App\Paper;
use Validator;


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
        $paper = Paper::create($request->all());
        return new PaperResource($paper);
    }

    public function show(ShowPaper $request, $id)
    {
        return new PaperResource(Paper::findOrFail($id));
    }

    public function update(UpdatePaper $request, $id)
    {
        $paper = Paper::findOrFail($id);
        $paper->update($request->all());
        return new PaperResource($paper);
    }

    public function destroy(DestroyPaper $request, $id)
    {
        Paper::findOrFail($id)->delete();
    }
}