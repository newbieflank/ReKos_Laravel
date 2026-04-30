<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'payment_id',
        'order_id',
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

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class, 'payment_id');
    }
}
