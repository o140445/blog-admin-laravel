<?php

namespace App\Http\Controllers\Api\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Panfu\Laravel\HCaptcha\Facades\HCaptcha;

class AuthRequest extends FormRequest
{
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'code' => '0',
            'msg' => $validator->errors()->first(),
        ], 400));
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $path = $this->path();
        $paths = explode('/', $path);

        switch (end($paths)) {
            case "register";
                return [
                    'user_name' => 'required|string|unique:users',
                    'email' => 'required|email|unique:users',
                    'password' => 'required|string|min:6',
                    'h-captcha-response' => 'hcaptcha',
                ];
            case "login";
                return [
                    'user_name' => 'required|string',
                    'password' => 'required|string|min:6',
                    'h-captcha-response' => 'hcaptcha',
                ];
            default:
                return [];
        }
    }

    public function messages()
    {
        return [
            'user_name.required' => '用户名是必须的',
            'user_name.unique' => '用户名已被注册',
            'email.required' => '邮箱是必须的',
            'email.email' => '请输入有效的邮箱地址',
            'email.unique' => '该邮箱已被注册',
            'password.required' => '密码是必须的',
            'password.min' => '密码至少需要6个字符'
        ];
    }
}
