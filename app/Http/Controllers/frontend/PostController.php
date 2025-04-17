<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Post;
use App\Notifications\NewCommentNotify;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function show($slug)
    {

        $mainPost = Post::active()->with(['comments' => function ($query) {
            $query->latest()->limit(3);
        }])->whereslug($slug)->first();

    
        if(!$mainPost){
            return redirect()->back()->with('warning' , 'try agaim later!'); 
        }
            $category = $mainPost->category;

        $posts_belongs_to_category = $category->posts()->limit(5)->get();
        $mainPost->increment('num_of_views');

        return view('frontend.show', compact('mainPost', 'posts_belongs_to_category'));
    }


    public function getAllPosts($slug)
    {

        $post = Post::active()->whereslug($slug)->first();
        $comments = $post->comments()->with('user')->get();
        return response()->json($comments);
    }

    public function saveComment(Request  $request)
    {
        $request->validate([
            'user_id'=>['required' , 'exists:users,id'],
            'comment'=>['required' , 'string' , 'max:200'],
        ]);

        $comment = Comment::create([
            'user_id'=>$request->user_id,
            'post_id'=>$request->post_id,
            'comment'=>$request->comment,
            'ip_address'=>$request->ip(),

        ]);

        $post = Post::findOrFail($request->post_id);


        // if(auth()->user()->id != $request->user_id){
            $user = $post->user;
            
            $user->notify(new NewCommentNotify($comment , $post));
        // }

        $comment->load('user');

        if(!$comment){
            return response()->json([
                'data' => "operation failed",
                'status'=>403,

            ]);
        }
        return response()->json([
            'msg' => "comment stored successfully!",
            'comment'=>$comment,
            'status'=>201,
            

        ]);
        
    }
}
