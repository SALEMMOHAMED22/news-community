<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

use function PHPUnit\Framework\returnSelf;

class HomeController extends Controller
{
    public function index(){

        $posts = Post::active()->with('images')->latest()->paginate(9);
      
        $greetest_posts_views = Post::active()->with('images')->orderBy("num_of_views" , "desc")->limit(3)->get();
        $oldest_news = Post::active()->oldest()->take(3)->get();
        $greetest_posts_comments = Post::active()->withCount('comments')
        ->orderby('comments_count' , 'desc')
        ->take(3)
        ->get();

        $categories = Category::has('posts' , '>=' , 2)->active()->get();
        $categories_with_posts = $categories->map(function($category){
          $category->posts = $category->posts()->active()->limit(4)->get();
          return $category;
        });


      return view("frontend.index" , ["posts"=>$posts , 
      "greetest_posts_views"=>$greetest_posts_views ,
       "oldest_news"=>$oldest_news,
       "greetest_posts_comments"=>$greetest_posts_comments,
       "categories_with_posts" =>$categories_with_posts,
      ]);
    }
}
