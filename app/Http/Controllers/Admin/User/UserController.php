<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\utils\ImageManger;
use Flasher\Prime\Stamp\ViewStamp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use PhpParser\Node\Stmt\TryCatch;

class UserController extends Controller
{
    public function __construct(){
        $this->middleware('can:users') ;
    }
    /**
     * Display a listing of the resource.
     */ 
    public function index()
    {
        // return request();
        $users = User::when(request()->keyword, function ($query) {
            $query->where('name', 'LIKE', '%' . request()->keyword . '%')
                ->orwhere('email', 'LIKE', '%' . request()->keyword . '%');
        })
            ->when(!is_null(request()->status), function ($query) {
                $query->where('status', request()->status);
            })
            ->orderBy(request('sort_by', 'id'), request('order_by', 'desc'))->paginate(request('limit_by', 5));

        return view('Admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
       $request->validated();
        try {
            DB::beginTransaction();
            $request->merge([
                'email_verified_at' => $request->email_verified_at == 1 ? now() : null,
            ]);

            $user =  User::create($request->except(['_token', 'image', 'passord_confirmation']));
            ImageManger::uploadImages($request, null, $user);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }

        return redirect()->back()->with('success', ' User Created Successfully ');
       
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::findOrFail($id);
        return view('Admin.users.show' , compact('user'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        // return $request;
        $user = User::findOrFail($id);
        ImageManger::delteImageFromLocale($user->image);
        if (!$user->delete()) {
            Session::flash('error', 'Something Error');
            return redirect()->back();
        }

        Session::flash('success', 'User Deleted Successfully');
        return redirect()->route('admin.users.index');
    }
    public function changeStatus($id)
    {

        $user = User::findOrFail($id);
        if ($user->status == 1) {
            $user->update([
                'status' => 0,
            ]);
            Session::flash('success', 'User Blocked Successfully');
        } else {
            $user->update([
                'status' => 1,
            ]);
            Session::flash('success', 'User Unblocked Successfully');
        }
        return redirect()->back();
    }
}
