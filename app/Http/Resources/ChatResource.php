<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class ChatResource extends JsonResource
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
            'dates' => [
                'created_at' => $this->created_at,
                'created_at_human' => $this->created_at->diffForHumans()
            ],
            'is_unread' => $this->isUnreadForUser(Auth::id()),
            'latest_message' => new MessageResource($this->LatestMessage),
            'participants' => UserResource::collection($this->participants),
        ];
    }
}