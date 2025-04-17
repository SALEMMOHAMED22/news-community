<?php

namespace App\Livewire\Admin;

use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use Livewire\Component;
use App\Models\Category;

class Statistics extends Component
{
    public function render()
    {
        $active_categories_count = Category::where('status', 1)->count();
        $active_users_count = User::where('status', 1)->count();
        $active_posts_count = Post::where('status', 1)->count();
        $comments_count = Comment::where('status', 1)->count();
        return view('livewire.admin.statistics', [
            'active_categories_count' => $active_categories_count,
            'active_users_count' => $active_users_count,
            'active_posts_count' => $active_posts_count,
            'comments_count' => $comments_count,
        ]);
    }
}
