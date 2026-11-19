<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Dish extends Model
{
    use HasFactory;

    protected $fillable = [
        'eatery_id',
        'name',
        'price',
        'is_bestseller',
    ];

    // Convert bestseller status to true or false.
    protected function casts(): array
    {
        return [
            'is_bestseller' => 'boolean',
        ];
    }

    // Each dish belongs to one eatery.
    public function eatery(): BelongsTo
    {
        return $this->belongsTo(Eatery::class);
    }
}

