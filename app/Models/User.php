<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    function friendsPendingOfMine()
    {
        return $this->belongsToMany(self::class, 'friends', 'user_id', 'friend_id')
            ->wherePivot('state', '=', 'pending')
            ->withPivot('state');
    }
    function friendPendingOf()
    {
        return $this->belongsToMany(self::class, 'friends', 'friend_id', 'user_id')
            ->wherePivot('state', '=', 'pending')
            ->withPivot('state');
    }
    function mergePendingFriends()
    {
        return $this->friendsPendingOfMine->merge($this->friendPendingOf);
    }

    //я исправлю этот потом
    function friendsAcceptedOfMine()
    {
        return $this->belongsToMany(self::class, 'friends', 'user_id', 'friend_id')
            ->wherePivot('state', '=', 'pester')
            ->withPivot('state');
    }
    function friendAcceptedOf()
    {
        return $this->belongsToMany(self::class, 'friends', 'friend_id', 'user_id')
            ->wherePivot('state', '=', 'pester')
            ->withPivot('state');
    }
    function mergeAcceptedFriends()
    {
        return $this->friendsPendingOfMine->merge($this->friendPendingOf);
    }
}
