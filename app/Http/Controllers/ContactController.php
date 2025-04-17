<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\frontend\ContactRequest;
use App\Notifications\NewContactNotify;
use Illuminate\Support\Facades\Notification;

class ContactController extends Controller
{
     public function index(){
        return view('frontend.contact-us');
     }

     public function store(ContactRequest $request){
       
      $request->validated();

      $request->merge([
         'ip_address'=>$request->ip(),
      ]);

      $contact =   Contact::create($request->except('_token'));
      $admins = Admin::get();
      Notification::send($admins , new NewContactNotify($contact));
     

      if(!$contact){
         Session::flash('error' , "contact failed!");
         return redirect()->back();
      }

      Session::flash('success' , "Your message created successfully !");
      return redirect()->back();
     }
}
