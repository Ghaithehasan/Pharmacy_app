<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\ApiLocalization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('login-user' , [AuthController::class , 'login'])->middleware([ApiLocalization::class]);

Route::post('register-user' , [AuthController::class , 'register'])->middleware([ApiLocalization::class]);

Route::post('logout-user',[AuthController::class , 'logout'])->middleware(['auth:api' , ApiLocalization::class]);

Route::post('verify-email-code' , [AuthController::class , 'verifyEmail'])->middleware(['auth:api' , ApiLocalization::class]);

Route::get('/verify-email', [AuthController::class, 'verifyEmailLink']);

Route::get('auth/google' , [AuthController::class , 'redirectToGoogle']);

Route::get('auth/google/callback' , [AuthController::class , 'handleGoogleCallback']);

Route::apiResource('users' , UserController::class)->middleware([ApiLocalization::class]);

Route::apiResource('roles' , RoleController::class)->middleware([ApiLocalization::class]);

Route::get('show-all-permissions' , [RoleController::class , 'getAllPermissions'])->middleware([ApiLocalization::class]);


























































// Route::get('check-token' , [AuthController::class , 'check'])->middleware('auth:api');
