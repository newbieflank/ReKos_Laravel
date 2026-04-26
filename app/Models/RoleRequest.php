<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleRequest extends Model
{
    use HasFactory;

    /**
     * Kolom yang dapat diisi secara massal.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'status',
    ];

    /**
     * Relasi ke model User.
     * Satu pengajuan (RoleRequest) dimiliki oleh satu User.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope untuk memudahkan filter data yang sedang pending (Opsional).
     * Bisa digunakan di Controller: RoleRequest::pending()->get();
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
}
