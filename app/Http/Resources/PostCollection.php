<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\PostResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PostCollection extends ResourceCollection
{

    
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'posts' => PostResource::collection($this->collection),
            'count' => $this->count(),
            'desc' => 'this is a collection of all posts',
            
    
        ];
    }
}



