<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        
        $data =  [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'num_of_views' => $this->num_of_views,
            'status' => $this->status(),
            'date' => $this->created_at->format('y-m-d h:i:s'),
            'publisher' => $this->user_id == null ?new AdminResource($this->admin) :new UserResource($this->user) ,

            'media' => ImageResource::collection($this->images),
            'category' => $this->category->name,

            
            // 'post_url' => route('frontend.post.show', $this->slug),
            // 'post_endpoint' => url('api/post/' . $this->slug),
            // 'user' => new UserResource($this->user),
            // 'admin' => new AdminResource($this->admin),
        ];
        
        if($request->is('api/posts/show/*')){
            $data['comment_able']             = $this->comment_able == 1 ? 'active' : 'inactive';
            $data['small_description']        = $this->small_desc;
            $data['category']                 = new CategoryResource( $this->category);
        
        }
        return $data;
    }
    
}


