<?php

use App\Http\Controllers\Api\Controller\AuthController;
use App\Http\Controllers\Api\Controller\UserController;
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
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login'])->name('login');

// 需要身份验证的路由
Route::middleware('auth:api')->group(function () {
    Route::get('logout', [AuthController::class, 'logout']);
    Route::get('refresh', [AuthController::class, 'refresh']);

    Route::get('user', [UserController::class, 'getDetails']);
});
