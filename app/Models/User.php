<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;
use App\Notifications\VerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use App\Notifications\passwordReset ;


class User extends Authenticatable implements JWTSubject ,  MustVerifyEmail
{
    use HasFactory, Notifiable , SpatialTrait;

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
        'tagline' ,
        'about' ,
        'username' ,
        'formatted_address',
        'available_to_hire'
    ];

    protected $spatialFields = [
        'location',
    ];
    protected $appends = [
        'longitude',
        'latitude',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];



    public function sendEmailVerificationNotification() {

            $this->notify(new VerifyEmail) ;
        
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