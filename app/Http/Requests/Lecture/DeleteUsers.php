<?php

namespace App\Http\Requests\Lecture;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use App\Lecture;

class DeleteUsers extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = Auth::user();
        $lecture = Lecture::find($this->route('id'));
        return $user->can('lecture-store') || $user->id == $lecture->user_id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'users' => 'required|array|exists:lecture_user,user_id'
        ];
    }
}
