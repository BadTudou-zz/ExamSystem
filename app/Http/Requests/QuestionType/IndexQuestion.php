<?php

namespace App\Http\Requests\QuestionType;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;


class IndexQuestion extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->can('questionType-store');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
        ];
    }

}
