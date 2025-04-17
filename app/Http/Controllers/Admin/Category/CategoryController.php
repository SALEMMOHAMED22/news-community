<?php

namespace App\Http\Controllers\Admin\Category;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\categoryRequest;
use Illuminate\Support\Facades\Session;

class CategoryController extends Controller
{
    public function __construct(){
        $this->middleware('can:categories') ;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::withCount('posts')->when(request()->keyword, function ($query) {
            $query->where('name', 'LIKE', '%' . request()->keyword . '%');
               
        })
            ->when(!is_null(request()->status), function ($query) {
                $query->where('status', request()->status);
            })
            ->orderBy(request('sort_by', 'id'), request('order_by', 'desc'))->paginate(request('limit_by', 5));
        return view('Admin.categories.index', compact('categories'));
        }
    /**}
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(categoryRequest $request)
    {
        $request->validated();
        $category = Category::create($request->only(['name' , 'status']));
        if(!$category){
            Session::flash('error', 'Try Again Later');
            return redirect()->back();
        }else{
            Session::flash('success', 'Category Created Successfully');
            return redirect()->route('admin.categories.index');
        }
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(categoryRequest $request, string $id)
    {
       
        $category = Category::findOrFail($id);
        $category = $category->update($request->only('name' , 'status'));
        if(!$category){
            Session::flash('error', 'Try Again Later');
            return redirect()->back();
        }else{
            Session::flash('success', 'Category Updated Successfully');
            return redirect()->route('admin.categories.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);
        if (!$category->delete()) {
            Session::flash('error', 'Something Error');
            return redirect()->back();
        }

        Session::flash('success', 'Category Deleted Successfully');
        return redirect()->route('admin.categories.index');
    }
    public function changeStatus($id)
    {

        $category = Category::findOrFail($id);
        if ($category->status == 1) {
            $category->update([
                'status' => 0,
            ]);
            Session::flash('success', 'category Blocked Successfully');
        } else {
            $category->update([
                'status' => 1,
            ]);
            Session::flash('success', 'category Unblocked Successfully');
        }
        return redirect()->back();
    }
}
