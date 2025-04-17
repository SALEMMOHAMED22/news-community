<?php

namespace App\Http\Controllers\Api\Auth\Password;

use App\Models\User;
use Ichtrojan\Otp\Otp;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ResetPasswordRequest;

class ResetPasswordController extends Controller
{
    protected $otp2;
    public function __construct()
    {
        $this->otp2 = new Otp();
    }
    public function resetPassword(ResetPasswordRequest $request){
        // check if code is valid:
        // if not, return error message:
        $otp = $this->otp2->validate($request->email , $request->code);
        if($otp->status == false) {
            return apiResponse(400 , 'Code Is Not Valid');
        }
        // get user by email:
        $user = User::where('email' , $request->email)->first();
        // check if user exists:
        if(!$user) {
            return apiResponse(404 , 'User Not Found');
        }
        // update password:
        $user->update(['password' => bcrypt($request->password)]);
        return apiResponse(200 , 'Password Reset Successfully');
        // update password
        // return success message
    }
}





