<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Tag\Index as IndexTag;
use App\Http\Requests\Tag\Store as StoreTag;
use App\Http\Requests\Tag\Update as UpdateTag;
use App\Http\Requests\Tag\Show as ShowTag;
use App\Http\Requests\Tag\Destroy as DestroyTag;
use App\Http\Resources\TagCollection;
use App\Http\Resources\TagResource;
use Illuminate\Support\Facades\Auth;
use App\Tag;

class TagController extends Controller
{
    public function index(IndexTag $request)
    {
    	return new TagCollection(Tag::paginate());
    }

    public function show(ShowTag $request, $id)
    {
    	return new TagResource(Tag::findOrFail($id));
    }

    public function store(StoreTag $request)
    {
    	$request->request->add(
            [
                'creator_id' => Auth::user()->id
            ]
        );
        $tag = Tag::create($request->all());
        return $tag;
    }

    public function update(UpdateTag $request, $id)
    {
        $tag = Tag::findOrFail($id);
        $tag->update($request->all());
        return new TagResource($tag);
    }

    public function destroy(DestroyTag $request, $id)
    {
        Tag::findOrFail($id)->delete();
    }
}
