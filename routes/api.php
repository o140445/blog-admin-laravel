<?php

use App\Http\Controllers\Api;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// routes/api.php
// 注册和登录路由
Route::post('register', [Api\Controller\AuthController::class, 'register']);
Route::post('login', [Api\Controller\AuthController::class, 'login']);

// 需要身份验证的路由
Route::middleware('auth:api')->group(function () {
    // 添加需要认证的路由
//    Route::get('user', [AuthController::class, 'user']); // 例：获取当前用户信息
//    Route::post('logout', [AuthController::class, 'logout']);
    // 在这里添加其他需要认证的路由
});
