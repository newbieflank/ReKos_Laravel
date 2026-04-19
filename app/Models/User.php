<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function detail()
    {
        return $this->hasOne(UserDetail::class);
    }

    public function boardingHouses(): HasMany
    {
        return $this->hasMany(BoardingHouse::class, 'owner_id');
    }

    public function rentals(): HasMany
    {
        return $this->hasMany(Tenant::class, 'tenant_id');
    }
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class, 'tenant_id');
    }
    public function appReview(): HasOne
    {
        return $this->hasOne(AppReview::class);
    }
    public function boardingHouseReviews(): HasMany
    {
        return $this->hasMany(BoardingHouseReview::class, 'tenant_id');
    }
}
