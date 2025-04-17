<?php

namespace App\Http\Controllers\Admin\Authorization;

use Illuminate\Http\Request;
use App\Models\Authorization;
use App\Http\Controllers\Controller;
use App\Http\Requests\AuthorizationRequest;

class AuthorizationController extends Controller
{
    public function __construct(){
        $this->middleware('can:authorizations') ;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $authorizations = Authorization::paginate(5);
        return view('Admin.authorizations.index', compact('authorizations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Admin.authorizations.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AuthorizationRequest $request)
    {
        $authorization = new Authorization();
        $authorization->role = $request->role;
        $authorization->permissions = json_encode($request->permissions);
        $authorization->save();
        return redirect()->route('admin.authorizations.index')->with('success', 'Authorization created successfully');
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $authorization = Authorization::findOrFail($id);
        return view('Admin.authorizations.edit' , compact('authorization'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AuthorizationRequest $request, string $id)
    {
        $authorization = Authorization::findOrFail($id);
        $authorization->role = $request->role;
        $authorization->permissions = json_encode($request->permissions);
        $authorization->save();
        return redirect()->route('admin.authorizations.index')->with('success', 'Role updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $authorization = Authorization::findOrFail($id);
        if($authorization->admins()->count() > 0){
            return redirect()->back()->with('error', 'please delete all admins with this role first');
        }
        $authorization->delete();
        return redirect()->back()->with('success', 'Role deleted successfully');
    }
    
}
