<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
        'is_admin'
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
}
