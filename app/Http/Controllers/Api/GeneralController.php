<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryCollection;
use App\Http\Resources\CommentCollection;
use App\Http\Resources\PostCollection;
use App\Http\Resources\PostResource;

class GeneralController extends Controller
{
    public function getPosts()
    {

        $query = Post::query()
            ->with(['user', 'category', 'admin', 'images'])
            ->activeUser()
            ->activeCategory()
            ->active();
        if (request()->query('keyword')) {
            $query->where('title', 'LIKE', '%' . request()->query('keyword') . '%');
        }
        $posts = clone $query->paginate(4);
        $latest_posts = $this->latestPosts(clone $query);
        $oldest_posts = $this->oldestPosts(clone $query);
        $popular_posts = $this->popularPosts(clone $query);
        $most_read_posts = $this->mostReadPosts(clone $query);
        $categories_with_posts = $this->categoryWithPosts();

        $data = [
            'all_posts' => (new PostCollection($posts))->response()->getData(true),
            'latest_posts' => new PostCollection($latest_posts),
            'oldest_posts' => new PostCollection($oldest_posts),
            'popular_posts' => new PostCollection($popular_posts),
            'most_read_posts' => new PostCollection($most_read_posts),
            'categories_with_posts' => new CategoryCollection($categories_with_posts),
        ];

        return apiResponse(200, 'success', $data);
    }

    public function latestPosts($query)
    {
        $latest_posts = $query->latest()
            ->take(4)
            ->get();
        if (!$latest_posts) {
            return apiResponse(404, 'posts not found');
        }
        return $latest_posts;
    }

    public function oldestPosts($query)
    {
        $oldest_posts = $query->oldest()
            ->take(3)
            ->get();
        if (!$oldest_posts) {
            return apiResponse(404, 'posts not found');
        }

        return $oldest_posts;
    }

    public function popularPosts($query)
    {
        $popular_posts = $query->withCount('comments')
            ->orderBy('comments_count', "desc")
            ->take(3)
            ->get();
        if (!$popular_posts) {
            return apiResponse(404, 'posts not found');
        }
        return $popular_posts;
    }

    public function mostReadPosts($query)
    {
        $most_read_posts = $query->orderBy('num_of_views', 'desc')
            ->limit(3)
            ->get();
        if (!$most_read_posts) {
            return apiResponse(404, 'posts not found');
        }
        return $most_read_posts;
    }

    public function categoryWithPosts()
    {
        $categories = Category::active()->get();
        if (!$categories) {
            return apiResponse(404, 'posts not found');
        }

        $categories_with_posts = $categories->map(function ($category) {
            $category->posts = $category->posts()
                ->active()
                ->take(4)
                ->get();
            return $category;
        });

        if (!$categories_with_posts) {
            return apiResponse(404, 'posts not found');
        }
        return $categories_with_posts;
    }
    public function showPost($slug)
    {
        $post =  Post::active()
            ->activeUser()
            ->activeCategory()
            ->whereSlug($slug)
            ->first();
        if (!$post) {
            return apiResponse(404, 'Post Not Found');
        }
        $post->increment('num_of_views');
        return apiResponse(200, 'this is a post', new PostResource($post));
    }

    public function getPostComments($slug)
    {
        $post =  Post::active()
            ->activeUser()
            ->activeCategory()
            ->whereSlug($slug)
            ->first();
        if (!$post) {
            return apiResponse(404, 'Post Not Found');
        }
        $comments = $post->comments;
        if (!$comments) {
            return apiResponse(404, 'No Comments Found');
        }
        return apiResponse(200, 'this is post comments', new CommentCollection($comments));
    }
}
