<?php

namespace App\Services;

use App\Models\Api\User;
use Carbon\Carbon;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthService
{
    public function register(User $user)
    {
        return JWTAuth::fromUser($user);
    }

    /**
     * 登录
     *
     * @param $user_name
     * @param $password
     * @return array
     * @throws \Exception
     */
    public function login($user_name, $password)
    {
        if (!$token = JWTAuth::attempt(['user_name' => $user_name, 'password' => $password])) {
           throw new \Exception("账号密码错误！");
        }
        return $token;
    }

    public function logout()
    {
        auth()->logout();
    }

    public function refresh()
    {
        $data = [
            'access_token' => auth()->refresh(),
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ];
        return $data;
    }
}
