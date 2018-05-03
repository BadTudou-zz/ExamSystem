<?php

namespace App\Http\Requests\Exam;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use App\Exam;

class Update extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = Auth::user();
        $exam = Exam::find($this->route('exam'));
        return $user->can('exam-update') || $user->id == $exam->creator_id;

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'max:120',
            'paper_id' => 'exists:papers,id',
            'exam_type' => 'in:PRACTICE,EXAM',
            'describe' => 'max:255',
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
