<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if admin user already exists
        $existingUser = User::where('email', 'admin1@gmail.com')->first();
        
        if ($existingUser) {
            $this->command->info('Admin user already exists!');
            return;
        }
        
        // Create new admin user
        $user = new User();
        $user->name = 'Admin1';
        $user->email = 'admin1@gmail.com';
        $user->password = Hash::make('123456');
        $user->is_admin = true;
        $user->save();
        
        $this->command->info('Admin user created successfully!');
        $this->command->info('Email: admin1@gmail.com');
        $this->command->info('Password: 123456');
    }
}