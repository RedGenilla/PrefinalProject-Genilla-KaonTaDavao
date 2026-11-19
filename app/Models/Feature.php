<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Feature extends Model
{
    protected $fillable = [
        'name',
    ];

    // Features connect to eateries through a pivot table.
    public function eateries(): BelongsToMany
    {
        return $this->belongsToMany(
            Eatery::class,
            'eatery_feature'
        );
    }
}

