<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'designs' => DesignResource::collection($this->whenLoaded('designs')),
            'photo_url' => $this->photo_url,
            'username' => $this->username,
            'tagline' => $this->tagline,
            $this->mergeWhen(Auth::check() && Auth::id() == $this->id, [
                'email' => $this->email
            ]),
            'dates' => [
                'created_at' => $this->created_at,
                'created_at_human' => $this->created_at->diffForHumans()
            ],
            'about' => $this->about,
            // 'location' => $this->location,
            'formatted_address' => $this->formatted_address,
            'available_to_hire' => $this->available_to_hire,
        ];
    }
}