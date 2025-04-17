<?php

namespace App\Http\Controllers\Api;

use App\Models\Admin;
use App\Models\Contact;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Notifications\NewContactNotify;
use Illuminate\Support\Facades\Notification;
use App\Http\Requests\frontend\ContactRequest;

class ContactController extends Controller
{
    public function contactStore(ContactRequest $request){
        $request->validated();

        $request->merge([
           'ip_address'=>$request->ip(),
        ]);
  
        $contact =   Contact::create($request->all());
        if(!$contact){
          return apiResponse(400 , 'try again later');
         }
        $admins = Admin::get();
        Notification::send($admins , new NewContactNotify($contact));

        return apiResponse(201 , 'contact sent successfully');
       }
    
}

