<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\AdminPermission;

class AdminPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all admin users
        $adminUsers = User::where('is_admin', true)->get();
        
        // Define all available permissions
        $permissions = [
            'orders_view',
            'orders_edit', 
            'orders_delete',
            'products_manage',
            'categories_manage',
            'banners_manage',
            'users_manage',
            'permissions_manage',
            'service_packages_manage'
        ];
        
        // Grant all permissions to all admin users by default
        foreach ($adminUsers as $admin) {
            foreach ($permissions as $permission) {
                AdminPermission::grantPermission($admin->id, $permission);
            }
        }
        
        $this->command->info('Admin permissions seeded successfully!');
    }
}


