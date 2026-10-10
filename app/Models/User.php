<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
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
        'user_code',
        'name',
        'email',
        'password',
        'gender',
        'mobile',
        'country',
        'currency',
        'balance',
        'is_admin',
        'is_seller',
        'seller_photo',
        'seller_phone',
        'seller_status',
        'is_blocked',
        'block_reason',
        'deposit_hold',
        'hold_reason',
        'game_rig_mode',
        'referred_by',
        'theme',
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
            'password'          => 'hashed',
            'is_admin'          => 'boolean',
            'is_seller'         => 'boolean',
            'is_blocked'        => 'boolean',
            'deposit_hold'      => 'boolean',
        ];
    }

    /**
     * Get the KYC verification for the user.
     */
    public function kycVerification()
    {
        return $this->hasOne(KycVerification::class)->latestOfMany();
    }

    /**
     * Get KYC Status ('unverified', 'pending', 'verified', 'rejected')
     */
    public function getKycStatusAttribute(): string
    {
        $kyc = $this->kycVerification;
        return $kyc ? $kyc->status : 'unverified';
    }

    /**
     * Check if KYC is verified
     */
    public function isKycVerified(): bool
    {
        return $this->kyc_status === 'verified';
    }

    /**
     * Booted event to auto-generate unique 10-digit user_code
     */
    protected static function booted(): void
    {
        static::creating(function ($user) {
            if (empty($user->user_code)) {
                $code = strval(random_int(1000000000, 9999999999));
                while (static::where('user_code', $code)->exists()) {
                    $code = strval(random_int(1000000000, 9999999999));
                }
                $user->user_code = $code;
            }
        });
    }
}

