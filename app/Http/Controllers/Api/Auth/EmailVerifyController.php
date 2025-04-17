<?php

namespace App\Http\Controllers\Api\Auth;

use Ichtrojan\Otp\Otp;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Notifications\SendOtpVerifyUserEmail;

class EmailVerifyController extends Controller
{
    protected $otp;
    public function __construct()
    {
        $this->otp = new Otp();
    }

    public function emailVerify(Request $request){
        $request->validate(['token' =>  ['required' , 'max:8']]);

        $user = $request->user();

        $otp2 = $this->otp->validate($user->email , $request->token);

        if($otp2->status == false) {
            return apiResponse(400 , 'Code Is Not Valid');
        }
        // return $user;

        $user->update(['email_verified_at' => now()]);

        return apiResponse(200 , 'Email Verified Successfully');


    }

    public function sendOtpAgain(Request $request){
        $user = $request->user();

        $user->notify(new SendOtpVerifyUserEmail());
        return apiResponse(200 , 'Otp sent again successfully');
    }
}
