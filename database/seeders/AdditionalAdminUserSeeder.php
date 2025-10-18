<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdditionalAdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $email = env('ADMIN2_EMAIL', 'admin2@webchothue.com');
        $password = env('ADMIN2_PASSWORD', '12345678');

        $user = User::updateOrCreate(
            ['email' => $email],
            [
                'name' => 'Admin 2',
                'password' => Hash::make($password),
                'is_admin' => true,
            ]
        );

        if ($this->command) {
            $this->command->info('Admin user ensured:');
            $this->command->info('Email: ' . $email);
            $this->command->info('Password: ' . $password . ' (reset on each seed run)');
        }
    }
}


