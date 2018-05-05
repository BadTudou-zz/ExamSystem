<?php

namespace App\Http\Requests\Question;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class Update extends FormRequest
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
            'type_id' => 'exists:question_types,id',
            'level_type' => 'required|in:EASY,MIDDLE,HARD',
            'title' => 'required',
            'body'  => 'required',
            'answer' => 'required|max:120',
            'answer_comment' =>'max:250',
            'tags'     => 'array|exists:tags,id'
        ];
    }

    public function messages()
    {
        return [
            'type_id.exists' => '问题类型必须为有效值',
            'level_type.required'  => '问题等级不能为空，必须是【EASY,MIDDLE,HARD】之一',
            'title.required'  => '问题名称不能为空',
            'answer.required' => '问题答案不能为空'
        ];
    }
}
