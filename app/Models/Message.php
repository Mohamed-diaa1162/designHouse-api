<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Message extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['user_id', "chat_id", "body", 'last_read'];
    protected $touches = ['chat'];

    public function getBodyAttribute($value)
    {
        if ($this->trashed()) {
            // if (Auth::check()) return null;

            if (Auth::id() == $this->sender->id) {
                return  'You Delete This Message';
            } else {
                return "{$this->sender->name} deleted this message";
            }
        }
        return $value;
    }

    ###########################################################################################################
    //RelationShips

    public function chat()
    {
        return $this->belongsTo(Chat::class);
    }


    public function sender()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    ###########################################################################################################

}