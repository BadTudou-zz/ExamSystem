<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class Update extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(Request $request)
    {
        $user = Auth::user();
        return $user->can('user-update') || $user->id == $this->route('user');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'unique:users,email,'.$this->get('email'),
            'number' => 'unique:users,number,'.$this->get('number'),
            'phone' => 'unique:users,phone,'.$this->get('phone'),
            'qq' => 'unique:users,qq,'.$this->get('qq')
        ];
    }

    public function messages()
    {
        return [
            'email.unique' => '该邮箱已被使用',
            'number.unique'  => '该固定电话已被使用',
            'phone.unique'  => '该移动电话已被使用',
            'qq.unique'  => '该QQ已被使用',
        ];
    }
}
