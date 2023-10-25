<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Follower extends Model
{
    use HasFactory;

    protected $fillable = [
        'follower_id',
        'user_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function follower(): BelongsTo
    {
        return $this->belongsTo(User::class, 'follower_id', 'id');
    }

    protected function isFollowing(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => self::whereUserId($attributes['follower_id'])->whereFollowerId(auth()->id())->exists(),
        );
    }
}
