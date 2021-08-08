<?php

namespace App\Models\Traits;

use App\Models\like;
use Illuminate\Support\Facades\Auth;

trait Likable
{


    static function bootLikable()
    {
        static::deleting(function ($model) {
            $model->removeLikes();
        });
    }

    public function likes()
    {
        return $this->morphMany(like::class, 'likable');
    }

    public function like()
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'You are unauthorized ']);
        }

        if ($this->isLikedByUser(Auth::id())) {
            return;
        }
        $this->likes()->create(['user_id' => Auth::id()]);

        return response()->json(['message' => 'Like Add']);
    }

    public function unLike()
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'You are unauthorized ']);
        }

        if (!$this->isLikedByUser(Auth::id())) {
            return;
        }

        $this->likes()->where('user_id', Auth::id())->delete();

        return response()->json(['message' => 'Like Removed']);
    }


    public function isLikedByUser($user_id)
    {
        return (bool)$this->likes()->where('user_id', $user_id)->count();
    }


    public function removeLikes()
    {
        if ($this->likes()->count()) {
            $this->likes()->delete();
        }
    }
}