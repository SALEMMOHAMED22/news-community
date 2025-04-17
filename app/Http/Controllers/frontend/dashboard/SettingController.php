<?php

namespace App\Http\Controllers\frontend\dashboard;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use App\Http\Requests\frontend\SettingRequest;
use App\utils\ImageManger;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class SettingController extends Controller
{
    public function index(){

        $user = auth()->user();
        return view('frontend.dashboard.setting' , compact('user'));
    }

    public function update(SettingRequest $request){

        $request->validated();

        $user = User::findOrFail(auth()->user()->id);

        $user->update($request->except(['_token' , 'image']));

        if($request->hasFile('image')){
          
            ImageManger::updateImages($user,$request);
           

           
        }

        return redirect()->back()->with('success' , 'Profile Data Updated Successfully');
       
    }


    public function changePassword(Request $request){

        $request->validate([
            'current_password'=>['required'],
            'newPassword'=>['required' , 'confirmed'],
            'newPassword_confirmation'=>['required'],
        ]);

      

        if(! Hash::check($request->current_password , auth()->user()->password )){
            Session::flash('error' , 'pass does not match');
            return redirect()->back();
        }
        
        $user = User::findOrFail(auth()->user()->id);
       

        $user->update([
            'password' => $request->newPassword,
        ]);
        Session::flash('success' , 'password updated successfully');
        return redirect()->back();

    }
}
