<?php

namespace App\Livewire\Admin;

use App\Models\Post;
use App\Models\Comment;
use Livewire\Component;

class LatestPostsComments extends Component
{
    public function render()
    {
        $latest_posts = Post::with('comments')->withCount('comments')->where('status', 1)->orderBy('id', 'desc')->take(5)->get();
        $latest_comments = Comment::with(['post' , 'user'])->where('status', 1)->orderBy('id', 'desc')->take(5)->get();
        return view('livewire.admin.latest-posts-comments',
            [
                'latest_posts' => $latest_posts,
                'latest_comments' => $latest_comments,
            ]);
    }
}
