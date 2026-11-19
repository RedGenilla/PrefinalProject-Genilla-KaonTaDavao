<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Permit extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'eatery_id',
        'permit_no',
        'expires_on',
    ];

    // Convert expiry date into a date object.
    protected function casts(): array
    {
        return [
            'expires_on' => 'date',
        ];
    }

    // Each permit belongs to one eatery.
    public function eatery(): BelongsTo
    {
        return $this->belongsTo(Eatery::class);
    }
}

