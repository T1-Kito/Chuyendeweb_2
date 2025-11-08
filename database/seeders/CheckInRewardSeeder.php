<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class CheckInRewardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tạo dữ liệu mẫu cho một số user để test
        $users = User::where('is_admin', false)->take(3)->get();
        
        if ($users->count() > 0) {
            $this->command->info('Tạo dữ liệu điểm danh mẫu cho ' . $users->count() . ' user...');
            
            foreach ($users as $user) {
                // Tạo điểm danh cho 5 ngày liên tiếp
                for ($i = 1; $i <= 5; $i++) {
                    $checkInDate = now()->subDays(5 - $i);
                    
                    \App\Models\CheckIn::create([
                        'user_id' => $user->id,
                        'check_in_date' => $checkInDate,
                        'day_number' => $i,
                        'reward_type' => $i === 3 ? 'voucher' : 'day',
                        'reward_value' => $i === 3 ? '10%' : (string)$i,
                        'reward_description' => $i === 3 ? 'Voucher 10%' : "Ngày {$i}",
                        'is_claimed' => $i === 3 ? true : false,
                        'claimed_at' => $i === 3 ? $checkInDate : null,
                    ]);
                }
            }
            
            $this->command->info('Dữ liệu điểm danh mẫu đã được tạo thành công!');
        } else {
            $this->command->warn('Không có user nào để tạo dữ liệu mẫu!');
        }
    }
}
