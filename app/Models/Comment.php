<?php

namespace App\Models;

use App\Models\Post;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = [

        'comment',
        'ip_address',
        'status',
        'user_id',
        'post_id',
    ];

    public function post(){
        return $this->belongsTo(Post::class , "post_id");
    }

    public function user(){
        return $this->belongsTo(User::class , "user_id");
    }
    public function scopeActive($query){
        $query->where('status',1);
    }
}
