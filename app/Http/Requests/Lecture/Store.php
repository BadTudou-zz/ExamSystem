<?php

namespace App\Http\Requests\Lecture;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use App\Lecture;


class Store extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->can('lecture-store');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'course_id' =>'required|exists:courses,id',
            'name' => 'required|max:120',
            'describe' => 'required|max:120',
            'allowable_organization_ids' => 'array|exists:organizations,id',
            'allowable_user_ids' => 'array|exists:users,id',
            'max' => 'required|max:255'
        ];
    }
}
