<?php

namespace App\Http\Controllers\Admin\Profile;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:profile');
    }
    public function index()
    {
        return view('Admin.profile.index');
    }
    public function update(Request $request)
    {
        $request->validate($this->filter());
        $admin = Admin::findOrFail(auth('admin')->user()->id);
        if (!Hash::check($request->password, $admin->password)) {
            Session::flash('error', 'Password is incorrect');
            return redirect()->back();
        }
        $admin->update($request->except(['password', '_token']));
        Session::flash('success', 'Profile updated successfully');
        return redirect()->back();
    }



    public function filter()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email,' . auth('admin')->user()->id,
            'password' => 'required|string',
        ];
    }
}
