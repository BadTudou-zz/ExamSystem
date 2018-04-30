<?php

namespace App\Http\Requests\Paper;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use App\Paper;

class PaperMakeQuestions extends FormRequest
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
        return $user->can('paper-update') || $user->id == $paper->creator_id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'number' => 'required|max:120',
            'types' => 'required|json'
        ];
    }

     public function messages()
    {
        return [
            'number.required' => '题目数量不能为空',
            'types.required'  => '题目类型不能为空',
            'types.json'  => "题目类型必须为json对象，格式：{'问题类型':'数量'}"
        ];
    }
}
