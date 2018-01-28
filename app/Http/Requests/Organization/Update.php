<?php

namespace App\Http\Requests\Organization;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use App\Organization;

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
        $organization = Organization::find($this->route('organization'));
        return $user->can('organization-update') || $user->id == $organization->creator_id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $organization = Organization::find($this->route('organization'));

        return [
            'name' => 'max:120',
            'describe' => 'max:255',
            'max' => "numeric|min:{$organization->current}"
        ];
    }
}
