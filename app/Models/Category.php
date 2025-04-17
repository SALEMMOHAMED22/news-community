<?php


namespace App\Models;

use App\Models\Post;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory , Sluggable;
    protected $fillable = [
        'name',
        'slug',
        'status',
        'created_at',
    ];


    public function posts(){
        return $this->hasMany(Post::class, "category_id");
    }
    

    public function scopeActive($query){
       return $query->where('status' , 1);
    }
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name',
            ]
        ];
    }

    public function status(){
     return   $this->status == 1 ? 'Active' : 'Inactive' ;
    }
}

