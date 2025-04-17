<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {

        $request->validate([
            'search'=>['nullable', 'string', 'max:100'],
        ]);

        $keyWord = strip_tags($request->search);
        $posts = Post::active()->where('title', 'like', '%' . $keyWord . '%')
            ->orwhere('desc', 'like', '%' . $keyWord. '%')
            ->paginate(14);


        return view('frontend.search', compact('posts'));
    }
}
