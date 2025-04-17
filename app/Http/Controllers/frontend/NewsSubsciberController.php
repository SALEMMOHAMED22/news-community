<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Mail\frontend\NewSubscriberMail;
use App\Models\NewSubscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class NewsSubsciberController extends Controller
{
    public function store(Request $request){

        $request->validate([
            'email'=>['required','email' , 'unique:new_subscribers,email'],
        ]);


      $NewSubscriber =  NewSubscriber::create([
            'email'=>$request->email,
        ]);
        if(!$NewSubscriber){
            
            Session::flash('error' , 'please try again!');
         return   redirect()->back();
        }else{

            Mail::to($request->email)->send(new NewSubscriberMail());
            Session::flash('success' , 'thanks for your subscribe!');

            return   redirect()->back();
        }
        }

    
}
