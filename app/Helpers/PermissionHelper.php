<?php

namespace App\Helpers;

use App\Models\AdminPermission;

class PermissionHelper
{
    /**
     * Check if current user has specific permission
     */
    public static function hasPermission($permission)
    {
        if (!auth()->check() || !auth()->user()->is_admin) {
            return false;
        }
        
        return AdminPermission::hasPermission(auth()->id(), $permission);
    }

    /**
     * Check if current user has any of the given permissions
     */
    public static function hasAnyPermission($permissions)
    {
        if (!auth()->check() || !auth()->user()->is_admin) {
            return false;
        }
        
        $userPermissions = AdminPermission::getUserPermissions(auth()->id());
        
        foreach ($permissions as $permission) {
            if (in_array($permission, $userPermissions)) {
                return true;
            }
        }
        
        return false;
    }

    /**
     * Check if current user has all of the given permissions
     */
    public static function hasAllPermissions($permissions)
    {
        if (!auth()->check() || !auth()->user()->is_admin) {
            return false;
        }
        
        $userPermissions = AdminPermission::getUserPermissions(auth()->id());
        
        foreach ($permissions as $permission) {
            if (!in_array($permission, $userPermissions)) {
                return false;
            }
        }
        
        return true;
    }

    /**
     * Get current user's permissions
     */
    public static function getUserPermissions()
    {
        if (!auth()->check() || !auth()->user()->is_admin) {
            return [];
        }
        
        return AdminPermission::getUserPermissions(auth()->id());
    }
}



