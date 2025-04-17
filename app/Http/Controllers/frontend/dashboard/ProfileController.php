<?php

namespace App\Http\Controllers\frontend\dashboard;

use App\Models\Post;
use App\Models\Image;
use App\Models\Comment;
use App\utils\ImageManger;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;


class ProfileController extends Controller
{
    public function index()
    {

        $posts = auth()->user()->posts()->active()->with(['images'])->latest()->get();
        return view('frontend.dashboard.profile', compact('posts'));
    }


    public function storepost(PostRequest $request)
    {

        $request->validated();
        try {

            DB::beginTransaction();

            $request->comment_able == "on" ? $request->merge(['comment_able' => 1]) : $request->merge(['comment_able' => 0]);

            $post = auth()->user()->posts()->create($request->except(['_token', 'images']));

            ImageManger::uploadImages($request, $post);

            DB::commit();
            Cache::forget('read_more_posts');
            Cache::forget('latest_posts');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('errors', $e->getMessage());
        }

        Session::flash('success', "post created successfuly!");
        return redirect()->back();
    }

    public function deletePost(Request $request)
    {


        $post = Post::where('slug', $request->slug)->first();
        if (!$post) {
            abort(404);
        }
        ImageManger::deleteImages($post);
        $post->delete();

        return redirect()->back()->with('success', 'post deleted successfully!');
    }

    public function getComments($id)
    {

        $comments = Comment::with('user')->where('post_id', $id)->get();
        if (!$comments) {
            return response()->json([
                'data' => null,
                'msg' => 'No Comments Yet!',
            ]);
        }

        return response()->json([
            'data' => $comments,
            'msg' => 'comntain comments',
        ]);
    }

    public function editePost($slug)
    {
        $post = Post::with('images')->whereslug($slug)->first();
        return  view('frontend.dashboard.edite-post', compact('post'));
    }

    public function updatePost(PostRequest $request)
    {

        $request->validated();

        try {
            DB::beginTransaction();
            $post = Post::findOrFail($request->post_id);
        $request->comment_able == "on" ? $request->merge(['comment_able' => 1]) : $request->merge(['comment_able' => 0]);

        $post->update($request->except(['images' , '_token' , 'post_id']));

        // delete image from local
        if($request->hasFile('images')){
            
            if($post->images->count()>0){
                foreach($post->images as $image){
                    if(File::exists(public_path($image->path))){
                        File::delete(public_path($image->path));
                    }
                    $image->delete();
                }
            }

            // store new images 

            foreach ($request->images as $image) {
                $file = Str::uuid().time().'.' . $image->getClientOriginalExtension();
                $path = $image->storeAs('uploads/posts' , $file , ['disk'=>'uploads']);

                $post->images()->create([
                    'path'=>$path,
                ]);
            }




            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['errors'=>$e->getMessage()]);
        }
       

            Session::flash('success' , 'post updated successfully!');
            return redirect()->route('frontend.dashboard.profile');
           
    }

    public function deleteImage(Request $request)
    {

        $image = Image::find($request->key);


        if (!$image) {
            return response()->json([

                'status' => 404,
                'msg' => 'image not found',
            ]);
        }

        // delete from local 

        if (File::exists(public_path($image->path))) {
            File::delete(public_path($image->path));
        }

        $image->delete();
        return response()->json([
            'ststus' => 200,
            'msg' => 'image deleted',
        ]);
    }
}
