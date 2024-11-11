<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Friends extends Model
{
    protected $fillable = array('user_id', 'friend_id');

    public $timestamps = true;



    public static function sendRequest($email)
    {
        return self::create([
            'user_id' => Auth::user()->id,
            'friend_id' => User::where('email', '=', $email)->first()['id'],
        ]);
    }
    public function setPendingToPester()
    {
        $this->state = 'pester';
        return $this->save();
    }
}
