<?php

namespace App\Http\Controllers\frontend;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke($slug)
    {
        $category = Category::active()->whereslug($slug)->first();

        if(!$category){
            return redirect()->back()->with('warning' , 'try again later!');
        }
        $posts = $category->posts()->paginate(9);

        return view("frontend.category-posts" , compact('posts' , 'category'));
    }
}
