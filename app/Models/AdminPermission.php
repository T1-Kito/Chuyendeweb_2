<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminPermission extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'permission',
        'granted'
    ];

    protected $casts = [
        'granted' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Check if user has specific permission
     */
    public static function hasPermission($userId, $permission)
    {
        return static::where('user_id', $userId)
                    ->where('permission', $permission)
                    ->where('granted', true)
                    ->exists();
    }

    /**
     * Grant permission to user
     */
    public static function grantPermission($userId, $permission)
    {
        try {
            return static::updateOrCreate(
                ['user_id' => $userId, 'permission' => $permission],
                ['granted' => true]
            );
        } catch (\Exception $e) {
            \Log::error("Failed to grant permission: user_id={$userId}, permission={$permission}, error={$e->getMessage()}");
            throw $e;
        }
    }

    /**
     * Revoke permission from user
     */
    public static function revokePermission($userId, $permission)
    {
        try {
            return static::updateOrCreate(
                ['user_id' => $userId, 'permission' => $permission],
                ['granted' => false]
            );
        } catch (\Exception $e) {
            \Log::error("Failed to revoke permission: user_id={$userId}, permission={$permission}, error={$e->getMessage()}");
            throw $e;
        }
    }

    /**
     * Get all permissions for a user
     */
    public static function getUserPermissions($userId)
    {
        return static::where('user_id', $userId)
                    ->where('granted', true)
                    ->pluck('permission')
                    ->toArray();
    }
}
