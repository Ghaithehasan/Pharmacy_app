<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8|max:15'
        ]);

        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['message' => __('messages.invalid_credentials') , 'status' => 'error' , 'error_code' => 401], 401);
        }
        $user = auth()->user();
        return response()->json([
            'status' => 'success',
            'message' => __('messages.login_success'),
            'local' => app()->getLocale() ,
            'user_id' => $user->id,
            'token' => $token,
            'expires_in' => config('jwt.ttl') * 60,
            'status_code' => 200,
            'user' => $user
        ] , 200);

    }


    public function register(Request $request)
    {
        try{
        $data = $request->validate([
            'name' => 'required|string|max:40',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|max:20|confirmed',
            'phone' => 'required|numeric|unique:users,phone|digits_between:10,15',
            'gender' => 'required|in:male,female'
        ]);
        $data['password'] = Hash::make($data['password']);

        $user = User::create($data);
        // $user = new UserResource($user);


        $token = JWTAuth::fromUser($user);

        return response()->json([
            'status' => 'success',
            'message' => __('messages.register_success'),
            'token' => $token,
            'user' => new UserResource($user),
            'user_id' => $user->id ,
            'local' => app()->getLocale() ,
            'status_code' => 201
        ], 201);

    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => __('messages.server_error'),
            'error_code' => 500,
            'details' => $e->getMessage()
        ], 500);
    }

    }


    public function logout(Request $request)
    {
        try {
            JWTAuth::invalidate(JWTAuth::parseToken()); // إبطال التوكن الحالي
            return response()->json([
                'status' => 'success',
                'message' => 'تم تسجيل الخروج بنجاح'
            ] , 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'فشل تسجيل الخروج. حاول مرة أخرى!'
            ], 500);
        }
    }



}
