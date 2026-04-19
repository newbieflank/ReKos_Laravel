<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BoardingHouseReview extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenant_id',
        'boarding_house_id',
        'rating',
        'review',
    ];

    protected function casts(): array
    {
        return [
            'rating' => 'float',
        ];
    }

    /**
     * Relasi ke Penyewa
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'tenant_id');
    }

    /**
     * Relasi ke Boarding House yang diulas
     */
    public function boardingHouse(): BelongsTo
    {
        return $this->belongsTo(BoardingHouse::class);
    }
}
