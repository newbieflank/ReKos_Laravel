<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tenant extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenant_id',
        'room_id',
        'start_date',
        'end_date',
        'duration',
        'rental_type',
        'total_price',
        'status',
    ];

    /**
     * Casting tipe data
     */
    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'total_price' => 'integer',
        ];
    }

    /**
     * Relasi ke User (Si penyewa)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'tenant_id');
    }

    /**
     * Relasi ke Kamar yang disewa
     */
    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }
}
