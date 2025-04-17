<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;

class LoginController extends Controller
{
    public function login(Request $request)
    {

        $request->validate([
            'email' => ['required', 'email', 'max:80'],
            'password' => ['required', 'max:100'],
        ]);

        if (RateLimiter::tooManyAttempts($request->ip(), 2)) {
            $time = RateLimiter::availableIn($request->ip());
            return apiResponse(429, 'Too many attempts to login , Try again after: ' . $time . ' seconds');
        }

        RateLimiter::increment($request->ip());
        $remaining = RateLimiter::remaining($request->ip(), 2);
        $user = User::where('email', $request->email)->first();
        if ($user && Hash::check($request->password, $user->password)) {
            RateLimiter::clear($request->ip());
            $token = $user->createToken('user_token', [], now()->addMinutes(60))->plainTextToken;
            return apiResponse(200, ' Logged successfully', ['token' => $token]);
        }
        return apiResponse(401, 'Invalid credentials', ['remaining_attempts' => $remaining]);
    }
    public function logout(Request $request)
    {
        $user =  Auth::guard('sanctum')->user();
        $user->currentAccessToken()->delete();
        return apiResponse(200, 'Logged out successfully');
    }
}
