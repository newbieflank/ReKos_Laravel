<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AppReview extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'rating',
        'review',
    ];

    /**
     * Casting tipe data.
     */
    protected function casts(): array
    {
        return [
            'rating' => 'float',
        ];
    }

    /**
     * Relasi ke User yang memberikan ulasan.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
