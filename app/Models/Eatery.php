<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Eatery extends Model
{
    use HasFactory;
    // Fields allowed when creating or updating an eatery.
    protected $fillable = [
        'district_id',
        'name',
        'slug',
        'address',
        'price_range',
        'specialty',
        'is_open',
    ];

    // Convert is_open to true or false.
    protected function casts(): array
    {
        return [
            'is_open' => 'boolean',
        ];
    }

    // Use the slug instead of the ID in URLs.
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    // Each eatery belongs to one district.
    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class);
    }

    // Each eatery has one permit.
    public function permit(): HasOne
    {
        return $this->hasOne(Permit::class);
    }

    // Each eatery has many dishes.
    public function dishes(): HasMany
    {
        return $this->hasMany(Dish::class);
    }

    // Each eatery can have many reviews.
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    // Eateries can have multiple features.
    public function features(): BelongsToMany
    {
        return $this->belongsToMany(
            Feature::class,
            'eatery_feature'
        );
    }
}

