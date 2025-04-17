<?php

namespace App\Http\Controllers\Api\Account;

use App\Models\Post;
use App\Models\Comment;
use App\utils\ImageManger;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Http\Requests\CommentRequest;
use Illuminate\Support\Facades\Cache;
use App\Http\Resources\PostCollection;
use App\Http\Resources\CommentResource;
use App\Notifications\NewCommentNotify;

class PostController extends Controller
{
    public function getUserPosts()
    {
        $user = Auth::guard('sanctum')->user();

        if (!$user) {
            return apiResponse(401, 'Unauthorized');
        }

        $posts = $user->posts()->activeCategory()->active()->get();
        if ($posts->count() > 0) {
            return apiResponse(200, 'Posts found', new PostCollection($posts));
        }
        return apiResponse(404, 'No posts found');
    }


    public function storeUserPost(PostRequest $request)
    {
        try {
            DB::beginTransaction();

            $post = auth()->user()->posts()->create($request->except(['images']));

            ImageManger::uploadImages($request, $post);

            DB::commit();
            Cache::forget('read_more_posts');
            Cache::forget('latest_posts');
            return apiResponse(201, 'Post created');
        } catch (\Exception $e) {
            Log::error('error in storeUserPost: ' . $e->getMessage());
            return apiResponse(500, 'Internal server error');
        }
    }

    public function destroyUserPosts($post_id)
    {

        $user =  auth()->user();
        $post = $user->posts()->where('id', $post_id)->first();
        if (!$post) {
            return apiResponse(404, 'Post not found');
        }
        ImageManger::deleteImages($post);
        $post->delete();
        return apiResponse(200, 'Post deleted successfully');
    }


    public function getPostComments($post_id)
    {
        $user =  auth()->user();
        $post = $user->posts()->where('id', $post_id)->first();
        if (!$post) {
            return apiResponse(404, 'Post not found');
        }

        $comments = $post->comments;
        if ($comments->count() > 0) {
            return apiResponse(200, 'this commnets for post to this user ', CommentResource::collection($comments));
        }
        return apiResponse(404, 'No comments found');
    }

    public function updateUserPost(PostRequest $request, $post_id)
    {
        try {
            DB::beginTransaction();

            $user =  auth()->user();
            $post = $user->posts()->where('id', $post_id)->first();


            $post->update($request->except(['images', '_method']));

            // delete image from local
            if ($request->hasFile('images')) {

                ImageManger::deleteImages($post);
                ImageManger::uploadImages($request, $post);

            }
            DB::commit();
            return apiResponse(200, 'Post updated successfully');
        } catch (\Exception $e) {
            Log::error('error in updateUserPost: ' . $e->getMessage());
            return apiResponse(500, 'Internal server error');
        }
    }
    public function storePostComment(CommentRequest $request){
        
        $post = Post::find($request->post_id);
        if(!$post){
            return apiResponse(404, 'Post not found');
        } 

        $comment = $post->comments()->create([
            'user_id'=>auth()->user()->id,
            'comment'=>$request->comment,
            'ip_address'=>$request->ip(),
        ]);

        //



        if(auth()->user()->id != $post->user_id){
            $user = $post->user;
            
            $user->notify(new NewCommentNotify($comment , $post));
        }

        // $comment->load('user');

        if(!$comment){
            return apiResponse(403, 'operation failed');
        }
        return apiResponse(201, 'comment stored successfully!' , $comment);
        
    }
}
