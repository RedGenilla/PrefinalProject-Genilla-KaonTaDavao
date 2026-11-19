<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class District extends Model
{
    // Fields allowed when creating a district.
    protected $fillable = [
        'name',
    ];

    // A district has many eateries.
    public function eateries(): HasMany
    {
        return $this->hasMany(Eatery::class);
    }

    // Get reviews through the district's eateries.
    public function reviews(): HasManyThrough
    {
        return $this->hasManyThrough(
            Review::class,
            Eatery::class
        );
    }
}

