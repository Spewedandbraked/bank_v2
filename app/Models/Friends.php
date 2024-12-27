<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Friends extends Model
{
    protected $fillable = array('user_id', 'friend_id');

    public $timestamps = true;



    function friendsStatesOfMine()
    {
        return $this->hasMany(self::class, 'user_id', 'friend_id');
    }
    function friendStatesOf()
    {
        return $this->hasMany(self::class, 'friend_id', 'user_id');
    }
    function mergeStatesFriends()
    {
        return $this->friendsStatesOfMine->merge($this->friendStatesOf);
    }
}
