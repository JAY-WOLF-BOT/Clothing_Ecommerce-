<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FeedPostImage extends Model
{
    protected $fillable = ['feed_post_id', 'path', 'alt', 'position'];

    public function feedPost(): BelongsTo
    {
        return $this->belongsTo(FeedPost::class);
    }
}
