<?php

namespace App\Services;

use App\Models\Api\User;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function __construct(private User $userModel)
    {
    }

    public function getUserByName($user_name)
    {
        return $this->userModel->where(['user_name' => $user_name])->first();
    }

    public function createUser($user_name, $email, $password)
    {
        $user = $this->userModel::create([
            'user_name' => $user_name,
            'email' => $email,
            'password' => Hash::make($password),
        ]);

        return $user;
    }
}
