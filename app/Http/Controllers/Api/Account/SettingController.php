<?php

namespace App\Http\Controllers\Api\Account;

use App\Models\User;
use App\utils\ImageManger;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\frontend\SettingRequest;

class SettingController extends Controller
{
    public function updateSetting(SettingRequest $request , $user_id){
        $request->validated();

        $user = User::find(auth()->user()->id);

        if(!$user){
            return apiResponse(404 , 'User Not Found');
        }
        
        $user->update($request->except(['_method' , 'image']));
        
        if($request->hasFile('image')){
            ImageManger::uploadImages($request , null , $user);

        }
        return apiResponse(200 , 'User Updated Successfully');

    }

    public function updatePassword(Request $request , $user_id){

        $request->validate([
            'current_password'=>['required' , 'min:8' , 'max:20'],
            'newPassword'=>['required' , 'confirmed'],
            'newPassword_confirmation'=>['required'],
        ]);

      $user = User::find($user_id);
        if(!$user){
            return apiResponse(404 , 'User Not Found');
        }

        if(! Hash::check($request->current_password , auth()->user()->password )){
                return apiResponse(422 , 'current password is wrong');
        }
        

        $user->update([
            'password' => bcrypt( $request->newPassword),
        ]);
       return apiResponse(200 , 'Password Updated Successfully');

    }


}
