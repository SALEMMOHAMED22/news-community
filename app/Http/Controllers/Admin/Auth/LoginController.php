<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware(['guest:admin'])->only('showLoginForm', 'checkAuth');
        $this->middleware(['auth:admin'])->only('logout');
    }

    public function showLoginForm()
    {
        return view('Admin.auth.login');
    }

    public function checkAuth(Request $request)
    {

        $request->validate($this->filterData());

        if (Auth::guard('admin')->attempt([
            'email' => $request->email,
            'password' => $request->password
        ], $request->remember)) {
            // if admin has permession home -> redirect to home , else redire the first page in his permessions
            $permissions = Auth::guard('admin')->user()->authorization->permissions;
            $first_permission = $permissions[0];

                if (!in_array('home', $permissions)) {

                return redirect('admin/' . $first_permission);
            }
            return redirect(RouteServiceProvider::ADMINHOME);
        }
        return redirect()->back()->withErrors(['email' => "credentials does not match!"]);
        
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login.show');
    }

    public function filterData(): array
    {
        return [

            'email' => ['required', 'email'],
            'password' => ['required', 'min:8'],
            'remember' => ['in:off,on'],
        ];
    }
}
