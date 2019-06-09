<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Collection
 *
 * @property int $id
 * @property int $user_id
 * @property string $featured_image_path
 * @property string $name
 * @property string $subtitle
 * @property string $slug
 * @property int $followers
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Collection newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Collection newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Collection query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Collection whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Collection whereFeaturedImagePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Collection whereFollowers($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Collection whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Collection whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Collection whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Collection whereSubtitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Collection whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Collection whereUserId($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $followed_users
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Post[] $posts
 * @property-read \App\User $user
 */
class Collection extends Model
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function followed_users()
    {
        return $this->belongsToMany(User::class, 'collection_user', 'collection_id', 'user_id')->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function posts()
    {
        return $this->hasMany(Post::class, 'collection_id', 'id');
    }
}
