<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use App\utils\ImageManger;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Notifications\SendOtpVerifyUserEmail;

class RegisterController extends Controller
{
    public function register(UserRequest $request){

        DB::beginTransaction();
       try {
         // Create a new user
         $user = User::create([
            'name' => $request->post('name'),
            'email' => $request->post('email'),
            'username' => $request->post('username'),
            'phone' => $request->post('phone'),
            'country' => $request->post('country'),
            'city' => $request->post('city'),
            'street' => $request->post('street'),
            'password' => $request->post('password'),

        ]);

        if($request->hasFile('image')){
            ImageManger::uploadImages($request , null , $user);
        }
        $token = $user->createToken('user_token')->plainTextToken; 

        $user->notify(new SendOtpVerifyUserEmail());
        DB::commit();
        return apiResponse(201 , 'User created successfully' , ['token' => $token]);
       
    } catch (\Exception $e) {
        DB::rollback();
        Log::error('Error creating user' . $e->getMessage());
        return apiResponse(500 , 'An error occurred while creating user');
       }

    }
}
