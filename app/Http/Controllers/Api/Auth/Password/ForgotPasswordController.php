<?php

namespace App\Http\Controllers\Api\Auth\Password;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Notifications\SendOtpResetPassword;

class ForgotPasswordController extends Controller
{
    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $user = User::where('email', $request->email)->first();
        if(!$user) {
            return apiResponse(400 , 'User Not Found');
        }
        $user->notify(new SendOtpResetPassword());
        return apiResponse(200, 'Otp sent successfully , check your email');

      
       

       
    }
}
