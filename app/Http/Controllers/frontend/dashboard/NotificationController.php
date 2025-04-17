<?php

namespace App\Http\Controllers\frontend\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class NotificationController extends Controller
{
    public function index(){

        auth()->user()->notifications->markAsRead();
        return view('frontend.dashboard.notification');
        
    }


    public function deleteAll(){

            auth()->user()->notifications()->delete();
            Session::flash('success' , 'all notification deleted successfully');
            return redirect()->back();

    }
    public function delete(Request $request){

        $notification = auth()->user()->notifications()->where('id' , $request->notify_id)->first();
        if(!$notification){
            Session::flash('error' , 'notification not found');
            return redirect()->back();
        }

        $notification->delete();
        Session::flash('success' , 'notification deleted successfully');
            return redirect()->back();
    }

    public function readAll(){
        auth()->user()->unreadNotifications->markAsRead();
        return redirect()->back()->with('success' , 'All notifications mark as readed ');
        
    }


}
