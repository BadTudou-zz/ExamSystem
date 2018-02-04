<?php

namespace App\Http\Requests\PaperSection;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use App\Paper;

class Store extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = Auth::user();
        $paper = Paper::find($this->route('paper'));
        return $user->can('paper-destroy') || $user->id == $paper->creator_id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:120',
            'score' => 'required',
            'number' => 'required',
            'describe' => 'max:250',
            'questions' => 'array|exists:questions,id',
            'question_type' => 'required|in:SINGLE_CHOICE,MULTIPLE_CHOICE,TRUE_FALSE,FILL_IN,SHORT_ANSWER',
        ];
    }
}
