<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Mail\VarificationEmail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
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
        $data['verification_code'] = Str::random(6);

        $user = User::create($data);

        $verification_link = url('/api/verify-email/' . Crypt::encryptString($user->id));
        Mail::to($user->email)->send(new VarificationEmail($user->name , $user->verification_code , $verification_link));

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


    public function verifyEmail(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email|exists:users,email',
                'verification_code' => 'required|string|min:6|max:6'
            ]);

            $user = User::where('email', $request->email)
                        ->where('verification_code', $request->verification_code)
                        ->first();

            if (!$user) {
                return response()->json([
                    'status' => 'error',
                    'message' => __('messages.invalid_verification_code')
                ], 400);
            }

            $user->update([
                'email_verified_at' => now(),
                'verification_code' => null,
                'is_verified' => true
            ]);

            return response()->json([
                'status' => 'success',
                'message' => __('messages.verification_success')
            ], 200);

        } catch (\Exception $e) {
            // Log::error('Verification Error: ' . $e->getMessage());

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


    public function verifyEmailLink(Request $request)
    {
        try {
            // ✅ التحقق من وجود التوكن في الهيدر
            if (!$request->header('Authorization')) {
                return response()->json([
                    'status' => 'error',
                    'message' => __('messages.token_missing')
                ], 401);
            }

            // 🔥 استخراج معرف المستخدم من الـ JWT مباشرة
            $user = JWTAuth::parseToken()->authenticate();

            // 🛑 التحقق مما إذا كان الحساب قد تم تفعيله مسبقًا
            if ($user->email_verified_at) {
                return response()->json([
                    'status' => 'error',
                    'message' => __('messages.already_verified')
                ], 400);
            }

            // ✅ تحديث حالة الحساب إلى "مُفعَّل"
            $user->update([
                'email_verified_at' => Carbon::now(),
                'is_verified' => true
            ]);

            return response()->json([
                'status' => 'success',
                'message' => __('messages.verification_success')
            ], 200);

        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json([
                'status' => 'error',
                'message' => __('messages.token_expired'),
                'error_code' => 401
            ], 401);
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json([
                'status' => 'error',
                'message' => __('messages.invalid_token'),
                'error_code' => 401
            ], 401);
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json([
                'status' => 'error',
                'message' => __('messages.token_missing'),
                'error_code' => 401
            ], 401);
        } catch (\Exception $e) {
            Log::error('Verification Error: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => __('messages.server_error'),
                'error_code' => 500,
                'details' => $e->getMessage()
            ], 500);
        }
    }

}
