<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Cviebrock\EloquentTaggable\Taggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use App\Models\Traits\Likable;
use App\Models\comment;
use App\Models\User;




class Design extends Model
{
    use HasFactory, Taggable, Likable;


    protected $fillable = [
        'user_id',
        'image',
        'title',
        'description',
        'slug',
        'close_to_comment',
        'is_live',
        'upload_successfule',
        'disk',
        'team_id'
    ];



    public function getImagesAttribute()
    {
        return [
            'thumbnail' => $this->getImagePath('thumbnail'),
            'original'  => $this->getImagePath('original'),
            'large'     => $this->getImagePath('large')
        ];
    }

    protected function getImagePath($size)
    {
        // return Storage::disk($this->disk)
        return Storage::disk($this->disk)->url("uploads/designs/{$size}/" . $this->image);
        // return storage_path($this->image);
    }

    // relationships 

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->morphMany(comment::class, 'commentable')->orderBy('created_at', "asc");
    }

    public function team()
    {
        return $this->belongsTo(Team::class);
    }
}