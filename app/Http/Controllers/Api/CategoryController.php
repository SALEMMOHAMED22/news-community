<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryCollection;
use App\Http\Resources\PostCollection;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function getCategories(){
        $categories = Category::active()->get();
        if(!$categories){
            return apiResponse(404 , ' no Categories found');
        }
        return apiResponse(200 , 'Categories retrieved successfully' , new CategoryCollection($categories));
    }

    public function getCategoryPosts($slug){

        $category = Category::active()->where('slug', $slug)->first();
        if(!$category){
            return apiResponse(404 , 'Category not found');
        }
        $category_posts = $category->posts;
        if(!$category_posts){
            return apiResponse(404 , 'No posts found in this category');
        }
        return apiResponse(200 , 'Posts retrieved successfully' , new PostCollection($category_posts));
    }

} 
