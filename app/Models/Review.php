<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    protected $fillable = [
        'eatery_id',
        'user_id',
        'rating',
        'body',
    ];

    // The eatery being reviewed.
    public function eatery(): BelongsTo
    {
        return $this->belongsTo(Eatery::class);
    }

    // The user who wrote the review.
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

