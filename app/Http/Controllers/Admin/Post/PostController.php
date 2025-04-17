<?php

namespace App\Http\Controllers\Admin\Post;

use App\Models\Post;
use App\Models\Image;
use App\Models\Comment;
use App\Models\Category;
use App\utils\ImageManger;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class PostController extends Controller
{
    public function __construct(){
        $this->middleware('can:posts') ;
    }

    public function index()
    {
        $posts = Post::when(request()->keyword, function ($query) {
            $query->where('title', 'LIKE', '%' . request()->keyword . '%')
                ->orwhere('desc', 'LIKE', '%' . request()->keyword . '%');
        })
            ->when(!is_null(request()->status), function ($query) {
                $query->where('status', request()->status);
            })
            ->orderBy(request('sort_by', 'id'), request('order_by', 'desc'))->paginate(request('limit_by', 5));
        // return $posts;
        return view('Admin.posts.index', compact('posts'));
    }


    public function create()
    {
        $categories = Category::active()->select('id', 'name')->get();
        return view('Admin.posts.create', compact('categories'));
    }

    public function store(PostRequest $request)
    {

        $request->validated();
        try {

            DB::beginTransaction();


            $post = Auth::guard('admin')->user()->posts()->create($request->except(['_token', 'images']));

            ImageManger::uploadImages($request, $post);

            DB::commit();
            Cache::forget('read_more_posts');
            Cache::forget('latest_posts');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['errors', $e->getMessage()]);
        }

        Session::flash('success', "post created successfuly!");
        return redirect()->back();
    }

  
    public function show(string $id)
    {
        $post = Post::with('comments')->findOrFail($id);
        return view('Admin.posts.show', compact('post' ));
    }

  
    public function edit(string $id)
    {
        $post = Post::findOrFail($id);
        return view('Admin.posts.edit', compact('post'));
    }

 
    public function update(PostRequest $request, string $id)
    {
        $request->validated();

        try{
            DB::beginTransaction();
            $post = Post::findOrFail($id);
            $post->update($request->except(['images', '_token']));

            if ($request->hasFile('images')) {
                ImageManger::deleteImages($post);
                ImageManger::uploadImages($request, $post);
            }
            
            DB::commit();

        }catch(\Exception $e){
            DB::rollBack();
            return redirect()->back()->withErrors(['errros'=>$e->getMessage()]);
        }

        Session::flash('success', 'Post Updated Successfuly!');
        return redirect()->route('admin.posts.index');
    }
    public function deletePostImage(Request $request, $image_id)
    {
        $image = Image::find($request->key);
        if (!$image) {
            return response()->json([
                'status' => '201',
                'msg' => 'Image Not Found',
            ]);
        }

        ImageManger::delteImageFromLocale($image->path);
        $image->delete();

        return response()->json([
            'status' => 200,
            'msg' => 'image deleted successfully',
        ]);
    }

    public function destroy(string $id)
    {
        $post = Post::findOrFail($id);
        ImageManger::deleteImages($post);
        if (!$post->delete()) {
            Session::flash('error', 'Something Error');
            return redirect()->back();
        }

        Session::flash('success', 'Post Deleted Successfully');
        return redirect()->route('admin.posts.index');
    }


    public function changeStatus($id)
    {

        $post = Post::findOrFail($id);
        if ($post->status == 1) {
            $post->update([
                'status' => 0,
            ]);
            Session::flash('success', 'Post Blocked Successfully');
        } else {
            $post->update([
                'status' => 1,
            ]);
            Session::flash('success', 'Post Unblocked Successfully');
        }
        return redirect()->back();
    }

    public function deleteComment($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();
        Session::flash('success', 'Comment Deleted Successfully');
        return redirect()->back();
    }
}
