<?php

namespace App\Http\Requests\Exam;

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
        return Auth::user()->can('exam-store');

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
            'paper_id' => 'required|exists:papers,id',
            'exam_type' => 'required|in:PRACTICE,EXAM',
            'describe' => 'required|max:255',
            'score' => '',
            'min' => '',
            'allowable_lecture_ids' => 'array|exists:lectures,id',
            'allowable_orgaization_ids' => 'array|exists:organizations,id',
            'allowable_user_ids' => 'array|exists:users,id',
            'begin_at' => 'date',
            'start_at' => 'date',
            'finish_at' => 'date'

        ];
    }
}
