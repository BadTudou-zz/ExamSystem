<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateQuestion extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->can('question-update');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'question_type' => 'required|in:SINGLE_CHOICE,MULTIPLE_CHOICE,TRUE_FALSE,FILL_IN,SHORT_ANSWER',
            'level_type' => 'required|in:EASY,MIDDLE,HARD',
            'title' => 'required',
            'body'  => 'required',
            'answer' => '',
            'answer_comment' =>''
        ];
    }
}
