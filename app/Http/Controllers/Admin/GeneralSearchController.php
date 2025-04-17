<?php

namespace App\Http\Controllers\Admin;

use App\Models\Post;
use App\Models\User;
use App\Models\Admin;
use App\Models\Contact;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GeneralSearchController extends Controller
{
    public function search(Request $request){
        $option = $request->option;
        $keyword = $request->keyword;


        if($option == 'posts'){
            $posts = Post::where('title', 'like', '%'.$keyword.'%')->paginate(5);
            return view('Admin.posts.index', compact('posts'));
        }elseif($option == 'users'){
            $users = User::where('name', 'like', '%'.$keyword.'%')->paginate(5);
            return view('Admin.users.index', compact('users'));
        }elseif($option == 'categories'){
            $categories = Category::where('name', 'like', '%'.$keyword.'%')->paginate(5);
            return view('Admin.categories.index', compact('categories'));
        }elseif($option == 'contacts'){
            $contacts = Contact::where('name', 'like', '%'.$keyword.'%')->paginate(5);
            return view('Admin.contacts.index', compact('contacts'));
        }elseif($option == 'admins'){
            $admins = Admin::where('name', 'like', '%'.$keyword.'%')->paginate(5);
            return view('Admin.admins.index', compact('admins'));
        }
        else{
            return redirect()->back()->with('error', 'No results found');
        }

    }
}
