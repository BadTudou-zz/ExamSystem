<?php

namespace App\Http\Requests\QuestionType;

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
                return Auth::user()->can('questionType-update');

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|unique:question_types|max:255',
            'is_multiple_choice' =>  'required|boolean'
        ];
    }

    public function messages()
    {
        return [
            'title.required'  => '问题类型显示名称不能为空',
            'is_multiple_choice.required'  => '问题答案是否可多选不能为空',
            'title.unique'  => '该问题类型显示名称已被使用'
        ];
    }
}
