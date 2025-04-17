<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [
            'category_id'   => $this->id,
            'category_name' => $this->name,
            'category_slug' => $this->slug,
            'category_status' => $this->status(),
            'created_at' => $this->created_at->format('Y-m-d'),

           
        ];
        if(! $request->is('api/posts/show/*') && ! $request->is('api/categories')){
            $data['posts'] =  new PostCollection($this->posts);
        }
        return $data;
    }

    
}
