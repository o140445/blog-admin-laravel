<?php

namespace App\Http\Controllers\Api\Controller;


class UserController extends ApiController
{
    public function getDetails()
    {
        $user = auth()->user(); // 获取当前认证用户
        return $this->jsonSuccess($user);
    }
}
