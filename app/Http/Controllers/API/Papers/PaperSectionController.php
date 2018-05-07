<?php

namespace App\Http\Controllers\API\Papers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PaperSection\Index as IndexPaperSection;
use App\Http\Requests\PaperSection\Show as ShowPaperSection;
use App\Http\Requests\PaperSection\Store as StorePaperSection;
use App\Http\Requests\PaperSection\Update as UpdatePaperSection;
use App\Http\Requests\PaperSection\Destroy as DestroyPaperSection;
use App\Http\Resources\PaperSectionResource;
use App\Http\Resources\PaperSectionCollection;
use Validator;
use App\Paper;
use App\PaperSection;


class PaperSectionController extends Controller
{
	public function index(IndexPaperSection $request)
	{
		$paper = Paper::find($request->paper);
		$sections = $paper->sections ? explode(",", $paper->sections) : [];
		return new PaperSectionCollection(PaperSection::whereIn('id', $sections)->paginate());
	}

	public function store(StorePaperSection $request)
	{
		$paper = Paper::findOrFail($request->paper);
		if ($request->has('questions')) {
			$request['questions'] = implode(",", $request->questions);
		}
		$section = PaperSection::create($request->all());
		$sections = $paper->sections ? explode(",", $paper->sections) : [];
		array_push($sections, $section->id);
		$paper->update(['sections' => implode(",", $sections)]);
        return new PaperSectionResource($section);
	}

	public function show(ShowPaperSection $request)
	{
		$section = PaperSection::findOrFail($request->section);
		$paper = Paper::findOrFail($request->paper);
		$sections = $paper->sections ? explode(",", $paper->sections) : [];
		if ( in_array($request->section, $sections)) {
			$section = PaperSection::findOrFail($request->section);
			return new PaperSectionResource($section);
		} else {
			return response()->json(['error'=> "No query results for model [App\PaperSection] {$request->section}"], 404);
		}
	}

	public function update(UpdatePaperSection $request)
	{
		$section = PaperSection::findOrFail($request->section);
		$paper = Paper::findOrFail($request->paper);	
		$section->update($request->all());
		return new PaperSectionResource($section);
	}

	public function destroy(DestroyPaperSection $request)
	{
		$paper = Paper::findOrFail($request->paper);
		$sections = $paper->sections ? explode(",", $paper->sections) : [];
		$key = array_search($request->section, $sections);
		if ($key !== FALSE) {
			unset($sections[$key]);
		} else {
			return response()->json(['error'=> "此试卷中没有ID为{$request->section}的章节"], 404);
		}
		$paper->update(['sections' => implode(",", $sections)]);
	}
}