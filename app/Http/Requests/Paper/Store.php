<?php

namespace App\Http\Requests\Paper;

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
        return Auth::user()->can('paper-store');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|max:120',
            'score' => 'required',
            'min' => 'required',
            'describe' => 'required|max:250',
            'sections' => 'array|exists:paper_sections,id',
            'tags'     => 'array|exists:tags,id'
        ];
    }

    public function messages()
    {
        return [
            'title.required' => '试卷名称不能为空',
            'title.max' => '试卷名称不能超过120个字符',
            'score.required'  => '试卷分值不能为空',
            'min.required'  => '试卷时长不能为空',
            'describe.required'  => '试卷描述不能为空',
            'describe.max'  => '试卷描述不能超过250个字符'
        ];
    }
}
