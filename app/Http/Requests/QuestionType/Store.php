<?php

namespace App\Http\Requests\QuestionType;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;


class Store extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->can('questionType-store');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|unique:question_types|max:255',
            'title' => 'required|unique:question_types|max:255',
            'delimiter' =>  'required|unique:question_types|max:10',
            'is_multiple_choice' => 'required|boolean'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '问题类型名称不能为空',
            'title.required'  => '问题类型显示名称不能为空',
            'delimiter.required'  => '问题分隔符不能为空',
            'name.unique'  => '该问题类型名称已被使用',
            'title.unique'  => '该问题类型显示名称已被使用',
            'delimiter.unique'  => '该问题分隔符已被使用'
        ];
    }
}
