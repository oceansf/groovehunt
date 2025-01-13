<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
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

    /**
     * Get the listings that the user has created (as a seller)
     */
    public function listings()
    {
        return $this->hasMany(Listing::class, 'seller_id');
    }

    /**
     * Get the listings that the user has purchased (as a buyer)
     */
    public function purchasedListings()
    {
        return $this->hasMany(Listing::class, 'buyer_id');
    }

    public function scopePublicInfo($query)
    {
        return $query->select('id', 'name', 'avatar');
    }
}
