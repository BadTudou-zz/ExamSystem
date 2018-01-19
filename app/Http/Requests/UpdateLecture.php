<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use App\Lecture;


class UpdateLecture extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = Auth::user();
        $lecture = Lecture::find($this->route('lecture'));
        return $user->can('lecture-update') || $user->id == $lecture->user_id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $lecture = Lecture::find($this->route('lecture'));
        logger($lecture);
        return [
            'name' => 'required|max:120',
            'describe' => 'required|max:120',
            'allowable_organization_ids' => 'required|array|exists:organizations,id',
            'allowable_user_ids' => 'array|exists:users,id',
            //'max' => "numeric|min:{$lecture->current}"
        ];
    }
}
