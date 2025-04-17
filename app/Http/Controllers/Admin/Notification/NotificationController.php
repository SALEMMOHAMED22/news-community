<?php

namespace App\Http\Controllers\Admin\Notification;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function __construct(){
        $this->middleware('can:notifications');
    }
    public function index(){
        Auth::guard('admin')->user()->unreadNotifications->markAsRead();
        $notifications = auth('admin')->user()->notifications()->get();
        // return $notifications;
        return view('admin.notifications.index', compact('notifications'));
    }
    public function destroy($id){
        $notification = auth('admin')->user()->notifications()->find($id);
        if($notification){
            $notification = $notification->delete();
            return redirect()->back()->with('success', 'Notification deleted successfully');
        }else{
            return redirect()->back()->with('error', 'Notification not found');
        }

        
    }

    public function deleteAll(){
        $notifications = auth('admin')->user()->notifications()->delete();
        if($notifications){
            return redirect()->back()->with('success', 'All Notifications deleted successfully');
        }else{
            return redirect()->back()->with('error', 'Notifications not found');
        }
    }

    
}
