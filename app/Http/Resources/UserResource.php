<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data =  [
            'user_name' => $this->name,
            'user_status' => $this->status(),
            'created_at' => $this->created_at->diffForHumans(),
        ];

        if($request->is('api/account/user')){
            $data['user_id'] = $this->id;
            $data['user_userName'] = $this->username;
            $data['user_email'] = $this->email;
            $data['user_phone'] = $this->phone;
            $data['country'] = $this->country;
            $data['city'] = $this->city;
            $data['street'] = $this->street;
            $data['image'] = asset( $this->image);
        }

        return $data;
    }
}
