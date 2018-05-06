<?php

namespace App\Http\Requests\Exam;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use App\Exam;

class Answer extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = Auth::user();
        $exam = Exam::find($this->route('id'));
        return $exam->users->contains($user->id);

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'answers' => 'required|json',
        ];
    }

    public function messages()
    {
        return [
            'answers.required' => '答案不能为空',
            'answers.json'  => '答案格式有误，应该为json',
        ];
    }
}
