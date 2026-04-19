<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Room extends Model
{
    use HasFactory;

    /**
     * Kolom yang dapat diisi secara massal.
     */
    protected $fillable = [
        'boarding_house_id',
        'room_name',
        'room_type',
        'room_size',
        'facilities',
        'daily_price',
        'weekly_price',
        'monthly_price',
        'available',
    ];

    protected function casts(): array
    {
        return [
            'facilities' => 'array',    // Supaya otomatis jadi Array PHP
            'available' => 'boolean',  // Menangani 0/1 jadi true/false
        ];
    }

    /**
     * Relasi ke BoardingHouse
     * Room dimiliki oleh satu BoardingHouse.
     */
    public function boardingHouse(): BelongsTo
    {
        return $this->belongsTo(BoardingHouse::class);
    }

    public function tenants(): HasMany
    {
        return $this->hasMany(Tenant::class);
    }
}
