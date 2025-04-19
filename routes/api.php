<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Controller;
use App\Http\Middleware\ApiLocalization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('login-user' , [AuthController::class , 'login'])->middleware([ApiLocalization::class]);

Route::post('register-user' , [AuthController::class , 'register'])->middleware([ApiLocalization::class]);

Route::post('logout-user',[AuthController::class , 'logout'])->middleware(['auth:api' , ApiLocalization::class]);
// Route::get('check-token' , [AuthController::class , 'check'])->middleware('auth:api');
