<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenant_id',
        'payment_method',
        'amount',
        'status',
        'payment_date',
    ];

    /**
     * Casting tipe data agar enak diolah di PHP.
     */
    protected function casts(): array
    {
        return [
            'payment_date' => 'datetime',
            'amount' => 'integer',
        ];
    }

    /**
     * Relasi ke User (Pembayar)
     */
    public function user(): BelongsTo
    {
        // Tetap arahkan ke tenant_id sebagai foreign key
        return $this->belongsTo(User::class, 'tenant_id');
    }
}
