<?php

namespace App\Http\Controllers\Api\Controller;

use App\Http\Controllers\Api\Requests\AuthRequest;
use App\Http\Controllers\Controller;
use App\Models\Api\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Tymon\JWTAuth\Facades\JWTAuth;

/**
 * 认证
 */
class AuthController extends Controller
{
    /**
     * 注册
     *
     * @param AuthRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(AuthRequest $request)
    {
        $user = User::create([
            'user_name' => $request->user_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = JWTAuth::fromUser($user);

        $data = $user;
        $data['token'] = $token;
        return $this->jsonSuccess($data);

    }

    /**
     * 登录
     *
     * @param AuthRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(AuthRequest $request)
    {
        $credentials = $request->only('user_name', 'password');

        if (!$token = JWTAuth::attempt($credentials)) {
            return $this->jsonError('账号密码错误');
        }

        $user = User::where('user_name', $credentials['user_name'])->first();

        $data = $user;
        $data['token'] = $token;
        return $this->jsonSuccess($data);
    }

}
