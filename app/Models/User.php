<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;
use App\Notifications\VerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use App\Notifications\passwordReset;
use App\Models\comment;
use App\Casts\PointCasting;
use App\Models\Design;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class User extends Authenticatable implements JWTSubject,  MustVerifyEmail
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     * 
     * 
     */


    protected $fillable = [
        'name',
        'email',
        'password',
        'tagline',
        'about',
        'username',
        'formatted_address',
        'available_to_hire'
    ];

    // protected $spatialFields = [
    //     'location',
    // ];

    // protected $cast = [
    //     'location' => PointCasting::class
    // ];
    // protected $appends = [
    //     'longitude',
    //     'latitude',
    // ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $appends = [
        'photo_url'
    ];

    public function getPhotoUrlAttribute()
    {
        return 'https://www.gravatar.com/avatar/' . md5(strtolower($this->email)) . 'jpg?size=200&d=mm';
    }


    // public function get($model, $key, $value, $attributes)
    // {
    //     return [
    //         'Lat' => $value->getLat(),
    //         'Lng' => $value->getLng()
    //     ];
    // }

    /**
     * Prepare the given value for storage.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  array  $value
     * @param  array  $attributes
     * @return mixed
     */
    // public function set($model, $key, $value, $attributes)
    // {
    //     return new Point($value['lat'], $value['lon']);
    // }

    ###########################################################################################################
    //RelationShips

    public function designs()
    {
        return $this->hasMany(Design::class);
    }

    public function comments()
    {
        return $this->hasMany(comment::class);
    }

    public function teams()
    {
        return $this->BelongsToMany(Team::class)->withTimestamps();
    }

    public function ownedTeams()
    {
        return $this->teams()->where('owner_id', $this->id);
    }

    public function isOwnerOfTeam($team)
    {
        return (bool)$this->teams()->where('id', $team->id)->where('owner_id', $this->id)->count();
    }

    public function Invitations()
    {
        return $this->hasMany(Invitation::class, 'recipient_email', 'email');
    }

    public function chats()
    {
        return $this->belongsToMany(Chat::class, 'participants', "chat_id", "user_id");
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function getChatWithUser($user_id)
    {
        $chat = $this->chats()->whereHas('participants', function ($query) use ($user_id) {
            $query->where('user_id', $user_id);
        })->first();

        // $chat = Chat::whereHas('participants', function ($query) use ($user_id) {
        //     $query->where('user_id', $user_id);
        // })->first();

        return $chat;
    }



    ###########################################################################################################

    public function sendEmailVerificationNotification()
    {

        $this->notify(new VerifyEmail);
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new passwordReset($token));
    }

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}