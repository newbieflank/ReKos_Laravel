<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Room extends Model
{
    use HasFactory;


    protected $fillable = [
        'boarding_house_id',
        'room_name',
        'room_type',
        'room_size',
        'facilities',
        'daily_price',
        'weekly_price',
        'monthly_price',
        'monthly_expense',
        'available',
    ];

    protected function casts(): array
    {
        return [
            'facilities' => 'array',    
            'available' => 'boolean',  
        ];
    }


    public function boardingHouse(): BelongsTo
    {
        return $this->belongsTo(BoardingHouse::class);
    }

    public function tenants(): HasMany
    {
        return $this->hasMany(Tenant::class);
    }
}
