<?php

namespace App\Http\Requests\PaperSection;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use App\Paper;

class Show extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = Auth::user();
        $exams = $user->exams->filter(function ($exam) {
            return $exam->paper->id == $this->route('paper');
        })->all();
        $paper = Paper::find($this->route('paper'));
        return $user->can('paper-destroy') || $user->id == $paper->creator_id || count($exams);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }
}
