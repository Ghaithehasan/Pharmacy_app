<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Laravel\Socialite\Facades\Socialite;

Route::get('/', function () {
    return view('welcome');
});


Route::get('auth/google' , [AuthController::class , 'redirectToGoogle']);
Route::get('auth/google/callback' , [AuthController::class , 'handleGoogleCallback']);

