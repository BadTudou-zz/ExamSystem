<?php

namespace App\Http\Requests\Paper;

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
        return Auth::user()->can('paper-store');
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
            'score' => 'required',
            'min' => 'required',
            'describe' => 'max:250',
            'sections' => 'array|exists:paper_sections,id',
            'tags'     => 'array|exists:tags,id'
        ];
    }
}
