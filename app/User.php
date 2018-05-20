<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function todo()
    {
        return $this->hasMany('App\Todo', 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function friends()
    {
        return $this->belongsToMany('App\User', 'friends', 'user_id', 'friend_id');
    }

    /**
     * @param $userId
     * @return mixed
     */
    public function hasFriendWithId($userId)
    {
        return $this->friends->contains($userId);
    }

    /**
     * @param $friendId
     */
    public function addFriendById($friendId)
    {
        $this->friends()->attach($friendId);

        $friend = User::query()->find($friendId);
        $friend->friends()->attach($this->id);
    }

    /**
     * @param $friendId
     */
    public function removeFriendById($friendId)
    {
        $this->friends()->detach($friendId);

        $friend = User::query()->find($friendId);
        $friend->friends()->detach($this->id);
    }

    /**
     * @param array $attributes
     * @return bool
     */
    public static function create(array $attributes = []): bool
    {
        return (new User($attributes))->save();
    }

    /**
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
