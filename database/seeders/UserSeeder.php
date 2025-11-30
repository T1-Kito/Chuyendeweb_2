<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Nguyễn Văn Anh',
                'email' => 'nguyenvananh@example.com',
                'phone' => '0901111111',
                'address' => '15 Nguyễn Văn Cừ, Hà Nội',
            ],
            [
                'name' => 'Trần Thị Bảo',
                'email' => 'tranthibao@example.com',
                'phone' => '0902222222',
                'address' => '28 Lê Lai, Đà Nẵng',
            ],
            [
                'name' => 'Lê Minh Cường',
                'email' => 'leminhcuong@example.com',
                'phone' => '0903333333',
                'address' => '42 Đinh Tiên Hoàng, TP.HCM',
            ],
            [
                'name' => 'Phạm Thị Dung',
                'email' => 'phamthidung@example.com',
                'phone' => '0904444444',
                'address' => '67 Trần Phú, Hải Phòng',
            ],
            [
                'name' => 'Hoàng Văn Em',
                'email' => 'hoangvanem@example.com',
                'phone' => '0905555555',
                'address' => '89 Nguyễn Thị Minh Khai, Cần Thơ',
            ],
            [
                'name' => 'Vũ Thị Phương',
                'email' => 'vuthiphuong@example.com',
                'phone' => '0906666666',
                'address' => '103 Hùng Vương, Huế',
            ],
            [
                'name' => 'Đỗ Văn Giang',
                'email' => 'dovangiang@example.com',
                'phone' => '0907777777',
                'address' => '125 Lý Tự Trọng, Nha Trang',
            ],
            [
                'name' => 'Bùi Thị Hoa',
                'email' => 'buithihoa@example.com',
                'phone' => '0908888888',
                'address' => '147 Phan Bội Châu, Vũng Tàu',
            ],
            [
                'name' => 'Ngô Văn Ích',
                'email' => 'ngovanich@example.com',
                'phone' => '0909999999',
                'address' => '169 Trường Chinh, Quy Nhơn',
            ],
            [
                'name' => 'Đinh Thị Kiều',
                'email' => 'dinhthikieu@example.com',
                'phone' => '0910000000',
                'address' => '191 Quang Trung, Vinh',
            ],
        ];

        foreach ($users as $userData) {
            User::firstOrCreate(
                ['email' => $userData['email']],
                [
                    'name' => $userData['name'],
                    'password' => Hash::make('password'),
                    'phone' => $userData['phone'],
                    'address' => $userData['address'],
                    'is_admin' => false,
                ]
            );
        }

        $this->command->info('Đã tạo 10 user thường thành công!');
    }
}
