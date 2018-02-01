<?php

namespace App\Http\Requests\Tag;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use App\Tag;

class Update extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = Auth::user();
        $tag = Tag::find($this->route('tag'));
        return $user->can('tag-update') || $user->id == $tag->creator_id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|unique:tags|max:120',
            'commentable_type' => 'array|in:QUESTION,PAPEr,COURSE,LECTURE,ORGANIZATION'
        ];
    }
}
