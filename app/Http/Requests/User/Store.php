<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class Store extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'captcha' => 'required',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '用户名不能为空',
            'email.required'  => '注册邮箱不能为空',
            'email.email'  => '注册邮箱格式有误',
            'email.unique'  => '该邮箱已被注册',
            'captcha.required'  => '验证码不能为空',
            'password.required'  => '密码不能为空',
            'c_password.required' => '两次输入的密码不一致',
            'c_password.same' => '两次输入的密码不一致',
        ];
}
}
