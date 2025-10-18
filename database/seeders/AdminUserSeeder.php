<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@webchothue.com',
            'password' => Hash::make('12345678'),
            'is_admin' => true,
        ]);
        
        $this->command->info('Admin user created successfully!');
        $this->command->info('Email: admin@webchothue.com');
        $this->command->info('Password: 12345678');
    }
}
