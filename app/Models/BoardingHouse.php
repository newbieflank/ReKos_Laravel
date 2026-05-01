<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BoardingHouse extends Model
{
    use HasFactory;

    /**
     * Kolom yang dapat diisi secara massal.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'owner_id',
        'boarding_house_name',
        'alamat',
        'latitude',
        'longitude',
        'boarding_house_type',
        'facilities',
        'description',
        'house_rule',
        'rating',
        'main_image',
        'other_images',
    ];

    protected function casts(): array
    {
        return [
            'facilities' => 'array',
            'rating' => 'float',
        ];
    }

    /**
     * Relasi ke User (Owner)
     * BoardingHouse dimiliki oleh satu User.
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function rooms(): HasMany
    {
        return $this->hasMany(Room::class);
    }
    public function reviews(): HasMany
    {
        return $this->hasMany(BoardingHouseReview::class);
    }
}
