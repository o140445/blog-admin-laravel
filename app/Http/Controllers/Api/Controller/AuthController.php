<?php

namespace App\Http\Controllers\Api\Controller;

use App\Http\Controllers\Api\Requests\AuthRequest;
use App\Http\Controllers\Controller;
use App\Models\Api\User;
use App\Services\AuthService;
use App\Services\UserService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Tymon\JWTAuth\Facades\JWTAuth;

/**
 * 认证
 */
class AuthController extends Controller
{

    protected  $authService;

    public function __construct(AuthService $authService, private UserService $userService)
    {
        $this->authService = $authService;
    }
    /**
     * 注册
     *
     * @param AuthRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(AuthRequest $request)
    {
        try {
            $user = $this->userService->createUser($request->user_name, $request->email, $request->password);
            $token = $this->authService->register($user);

            $data = [
                'id' => $user->id,
                'user_name' => $user->user_name,
                'email' => $user->email,
                'created_at' => Carbon::parse($user->created_at)->format('Y-m-d H:i:s')
            ];
            $data['token'] = $token;
            return $this->jsonSuccess($data);
        }catch (\Exception $e) {
            return $this->jsonError($e->getMessage());
       }


    }

    /**
     * 登录
     *
     * @param AuthRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(AuthRequest $request)
    {
        $user_name = $request->post('user_name');
        $password = $request->post('password');

        try {
            $token = $this->authService->login($user_name, $password);
            $user = $this->userService->getUserByName($user_name);

            $data = [
                'id' => $user->id,
                'user_name' => $user->user_name,
                'email' => $user->email,
                'created_at' => Carbon::parse($user->created_at)->format('Y-m-d H:i:s')
            ];

            $data['token'] = $token;
            return $this->jsonSuccess($data);
        }catch (\Exception $e) {
            return $this->jsonError($e->getMessage());
        }
    }

    /**
     * 退出
     *
     * @param AuthRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        $this->authService->logout();
        return $this->jsonSuccess();
    }

    /**
     * 刷新token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        $data = $this->authService->refresh();
        return $this->jsonSuccess($data);
    }
}
