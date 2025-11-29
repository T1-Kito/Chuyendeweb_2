<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
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
        'phone',
        'address',
        'avatar',
        'is_admin',
        'two_factor_enabled',
        'two_factor_code',
        'two_factor_expires_at',
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
            'is_admin' => 'boolean',
            'two_factor_enabled' => 'boolean',
            'two_factor_expires_at' => 'datetime',
        ];
    }

    public function rentals(): HasMany
    {
        return $this->hasMany(Rental::class);
    }

    /**
     * Get user's admin permissions
     */
    public function adminPermissions(): HasMany
    {
        return $this->hasMany(AdminPermission::class);
    }

    /**
     * Check if user has specific permission
     */
    public function hasPermission($permission): bool
    {
        return $this->adminPermissions()
                    ->where('permission', $permission)
                    ->where('granted', true)
                    ->exists();
    }

    /**
     * Get all user permissions
     */
    public function getPermissions(): array
    {
        return $this->adminPermissions()
                    ->where('granted', true)
                    ->pluck('permission')
                    ->toArray();
    }

    public function generateTwoFactorCode(): string
    {
        $code = (string) random_int(100000, 999999);

        $this->forceFill([
            'two_factor_code' => $code,
            'two_factor_expires_at' => now()->addMinutes(10),
        ])->save();

        return $code;
    }

    public function verifyTwoFactorCode(string $code): bool
    {
        if (empty($this->two_factor_code) || empty($this->two_factor_expires_at)) {
            return false;
        }

        if ($this->two_factor_expires_at->isPast()) {
            return false;
        }

        return hash_equals((string) $this->two_factor_code, (string) $code);
    }

    public function clearTwoFactorCode(): void
    {
        $this->forceFill([
            'two_factor_code' => null,
            'two_factor_expires_at' => null,
        ])->save();
    }

    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class);
    }

    public function favoriteProducts(): HasManyThrough
    {
        return $this->hasManyThrough(Product::class, Favorite::class, 'user_id', 'id', 'id', 'product_id');
    }
}
