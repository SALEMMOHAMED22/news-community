<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class SocialLoginController extends Controller
{
    public function redirect($provider){
        return Socialite::driver($provider)->stateless()->redirect();
    }
    
    public function callback($provider){
       try {
        $provider_user = Socialite::driver($provider)->stateless()->user();
        $user_from_db = User::where('email', $provider_user->email)->first();
        if($user_from_db){
            Auth::login($user_from_db);
            return redirect()->route('frontend.dashboard.profile');
        }
        $username = $this->generateUsername($provider_user->name);
       $user = User::create([
            'name' => $provider_user->name,
            'email' => $provider_user->email,
            'username' => $username,
            'image' => $provider_user->avatar,
            'status' => 1,
            'country' => 'updated',
            'city' => 'updated',
            'street' => 'updated',
            'email_verified_at' => now(),
            'password' => Hash::make(Str::random(8)),
        ]);
        Auth::login($user);
        return redirect()->route('frontend.dashboard.profile');
       } catch (\Exception $e) {
        return redirect()->route('login')->with('error', 'Something went wrong');
       }

        
    }

    public function generateUsername($name){
        $username = Str::slug($name);
        $count = 1;
        while(User::where('username', $username)->exists()){
            $username = Str::slug($name).'-'.$count;
            $count++;
        }
        return $username;
    }

}


           
