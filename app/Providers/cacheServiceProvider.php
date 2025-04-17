<?php

namespace App\Providers;

use view;
use App\Models\Post;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;

class cacheServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // read more 
        if (! Cache::has('read_more_posts')) {
            $read_more_posts = Post::select('id', 'title','slug')->latest()->limit(10)->get();
            Cache::remember('read_more_posts', 3600, function () use ($read_more_posts) {
                return $read_more_posts;
            });
        }

        // latest_posts
        if(!Cache::has('latest_posts')){
            $latest_posts = Post::select('id','slug' , 'title')->latest()->limit(5)->get();
            Cache::remember('latest_posts' , 3600 , function() use($latest_posts){
                return $latest_posts;
            });
        }

        //greetest_posts_comments
        if(!Cache::has('greetest_posts_comments')){
            $greetest_posts_comments = Post::withCount('comments')
            ->orderby('comments_count' , 'desc')
            ->take(5)
            ->get();

            Cache::remember('greetest_posts_comments' , 3600 , function() use($greetest_posts_comments){
                return $greetest_posts_comments;
            });
        }

        $read_more_posts = Cache::get('read_more_posts');
        $latest_posts = Cache::get('latest_posts');
        $greetest_posts_comments = Cache::get('greetest_posts_comments');

        view()->share([
            'read_more_posts' => $read_more_posts,
            'latest_posts'=>$latest_posts,
            'greetest_posts_comments'=>$greetest_posts_comments,
        ]);

       

     }
}
