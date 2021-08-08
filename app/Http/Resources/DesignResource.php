<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DesignResource extends JsonResource
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
            'title' => $this->title,
            'likes_count' => $this->likes()->count(),
            'description' => $this->description,
            'images' => $this->images,
            'slug' => $this->slug,
            'is_live' => $this->is_live,
            'tag_list' => [
                'tags' => $this->tagArray,
                'normalized' => $this->tagArrayNormalized,
            ],
            "team" => $this->team ? [
                'id' => $this->team->id,
                "name" => $this->team->name,
                'slug' => $this->team->slug,
            ] : null,
            'created_dates' => [
                'created_at' => $this->created_at,
                'created_at_human' => $this->created_at->diffForHumans()
            ],
            'updated_dates' => [
                'updated_at' => $this->updated_at,
                'updated_at_human' => $this->updated_at->diffForHumans()
            ],
            'user' => new UserResource($this->user),
            "comments" => CommentResource::collection($this->comments),
            "comments_count" => $this->comments()->count(),
        ];
    }
}