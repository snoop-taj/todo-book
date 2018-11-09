<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    protected $fillable = ['content', 'visibility'];

    const PUBLIC_VISIBILITY = 100;
    const FRIENDS_VISIBILITY = 200;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * @param array $attributes
     * @return bool
     */
    public static function create(array $attributes = []): bool
    {
        return (new Todo($attributes))->save();
    }

    /**
     * @return bool
     */
    public function isPublic(): bool
    {
        return $this->visibility === self::PUBLIC_VISIBILITY;
    }
}
