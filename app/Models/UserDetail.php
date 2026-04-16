<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class UserDetail extends Model
{
    use HasFactory, Notifiable;
    protected $table = "user_detail";

    protected $fillable = [
        'user_id',
        'phone',
        'gender',
        'birth_date',
        'occupation',
        'institution',
        'city',
        'address'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
