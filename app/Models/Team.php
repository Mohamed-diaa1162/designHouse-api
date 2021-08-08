<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'owner_id',
        'slug',
    ];

    protected static function boot()
    {
        parent::boot();

        static::created(function ($team) {
            // Auth::user()->teams()->attach($team->id);
            //dd($team);
            //$team->members()->attach(Auth::id()); // Error from here
            $team->members()->attach(Auth::id());
            //Log::info("message", $team->toArray());
        });

        static::deleting(function ($team) {
            $team->members()->sync([]);
        });
    }

    ###########################################################################################################
    //RelationShips

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function members()
    {
        return $this->belongsToMany(User::class, 'team_user', 'team_id', 'user_id')->withTimestamps();
    }

    public function desgins()
    {
        return $this->hasMany(Design::class);
    }

    public function hasUser(User $user)
    {
        return $this->members()->where('user_id', $user->id)->first() ? true : false;
    }

    public function Invitations()
    {
        return $this->hasMany(Invitation::class);
    }
    ###########################################################################################################

    //Get if there Pending Email or not  ..
    public function hasPendingInvite($email)
    {
        return (bool)$this->Invitations()->where('recipient_email', $email)->count();
    }
}