<?php
        
namespace App\Http\Controllers\Admin\Admin;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Models\Authorization;
use App\Http\Requests\AdminRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    public function __construct(){
        $this->middleware('can:admins') ;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admins = Admin::where('id' , '!=' , Auth::guard('admin')->user()->id)->when(request()->keyword, function ($query) {
            $query->where('name', 'LIKE', '%' . request()->keyword . '%')
                ->orWhere ('email', 'LIKE', '%' . request()->keyword . '%');
        })
            ->when(!is_null(request()->status), function ($query) {
                $query->where('status', request()->status);
            })
            ->orderBy(request('sort_by', 'id'), request('order_by', 'desc'))->paginate(request('limit_by', 5));

        return view('Admin.admins.index', compact('admins'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $authorizations = Authorization::select('id', 'role')->get();
        return view('Admin.admins.create' , compact('authorizations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AdminRequest $request)
    {
            $admin = Admin::create($request->except(['_token', 'password_confirmation']));
            if(!$admin){
                return back()->with('error' , 'There is an error');
            }
            return redirect()->route('admin.admins.index')->with('success' , 'Admin created successfully');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    public function changeStatus(string $id)
    {
        $admin = Admin::findOrFail($id);

        if ($admin->status == 1) {
            $admin->update([
                'status' => 0,
            ]);
            Session::flash('success', 'admin Blocked Suuccessfully!');
        } else {
            $admin->update([
                'status' => 1,
            ]);
            Session::flash('success', 'admin Active Suuccessfully!');
        }
        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $admin = Admin::findOrFail($id);
        $authorizations = Authorization::select('id', 'role')->get();
        return view('Admin.admins.edit' , compact('admin' , 'authorizations'));
    }

   

    public function update(AdminRequest $request, string $id)
    {
        $admin = Admin::findOrFail($id);
        if($request->password){

            $admin = $admin->update($request->except(['_token', 'password_confirmation']));
        }else{
            $admin = $admin->update($request->except(['_token', 'password', 'password_confirmation']));

        }
        if(!$admin){
            return back()->with('error' , 'There is an error');
        }
        return redirect()->route('admin.admins.index')->with('success' , 'Admin updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $admin = Admin::findOrfail($id);
        $admin = $admin->delete();
        if(!$admin){
            return back()->with('error' , 'There is an error');
        }
        return redirect()->route('admin.admins.index')->with('success' , 'Admin deleted successfully');
    }
}
