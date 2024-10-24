<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\Login;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // login
    public function login(LoginRequest $request)
    {
        $user = User::where('username', $request->username)
            ->where('status', 'active')
            ->first();

        if (!$user)
        {
            return response()->json('کاربر یافت نشد');
        }
        if (!Hash::check($request->password, $user->password))
        {
            return response()->json('رمز عبور صحیح نمی باشد');
        }
        $expiresAt = $request->remember_me ? now()->addWeek(1) : now()->addDay(1);
        $token = $user->createToken($request->username, expiresAt: $expiresAt)->plainTextToken;
        $user_data = UserResource::make($user);
        return response()->json([
            'token' => $token,
            'user' => $user_data
        ]);
    }

    // logout
    public function logout()
    {
        $user = auth()->user();
        $user->currentAccessToken()->delete();
    }
}
