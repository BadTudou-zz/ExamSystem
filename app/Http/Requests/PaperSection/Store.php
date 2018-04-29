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
            'questions' => 'array',
            'questions.*' => 'exists:questions,id|distinct',
            'scores' => 'required|json',
            'question_type' => 'required|exists:question_types,id'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '章节名称不能为空',
            'score.required'  => '章节分值不能为空',
            'number.required'  => '章节题目数量不能为空',
            'questions.array'  => '章节的问题必须为数组',
            'scores.json'  => '章节的分数必须为json',
            'question_type.required'  => '章节的问题类型不能为空',
            'question_type.exists'  => '章节的问题类型必须为有效值',
            'questions.*.exists' => ':attribute 该问题不存在',
            'questions.*.distinct' => ':attribute 问题不能重复'
        ];
    }
}
