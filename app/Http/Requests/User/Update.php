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
            'name'  => 'required|unique:users,name,'.$this->get('name'),
            'number' => 'required|unique:users,number,'.$this->get('number'),
            'phone' => 'required|unique:users,phone,'.$this->get('phone'),
            'qq' => 'required|unique:users,qq,'.$this->get('qq')
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '用户名不能为空',
            'name.unique'  => '该用户名已被使用',
            'number.required' => '固定电话不能为空',
            'number.unique'  => '该固定电话已被使用',
            'phone.required' => '移动电话不能为空',
            'phone.unique'  => '该移动电话已被使用',
            'qq.required' => 'QQ不能为空',
            'qq.unique'  => '该QQ已被使用'
        ];
    }
}
