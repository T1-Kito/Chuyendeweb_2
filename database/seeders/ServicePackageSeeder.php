<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ServicePackage;

class ServicePackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $packages = [
            [
                'name' => 'Gói 6 Tháng',
                'duration' => '6 Tháng',
                'description' => 'Gói dịch vụ cơ bản cho thuê thiết bị trong 6 tháng',
                'features' => [
                    'Thuê thiết bị trong 6 tháng',
                    'Hỗ trợ kỹ thuật cơ bản',
                    'Bảo hành tiêu chuẩn',
                    'Cài đặt miễn phí',
                    'Hướng dẫn sử dụng'
                ],
                'icon' => 'clock',
                'button_text' => 'Xem Chi Tiết',
                'button_icon' => 'arrow-right',
                'button_color' => 'primary',
                'is_popular' => false,
                'is_active' => true,
                'sort_order' => 1
            ],
            [
                'name' => 'Gói 12 Tháng',
                'duration' => '12 Tháng',
                'description' => 'Gói dịch vụ phổ biến với nhiều tính năng ưu đãi',
                'features' => [
                    'Tất cả dịch vụ gói 6 tháng',
                    'Hỗ trợ xuất hóa đơn',
                    'Hỗ trợ xuất tiền lương',
                    'Hỗ trợ bảo hành lỗi',
                    'Ưu tiên hỗ trợ kỹ thuật',
                    'Cập nhật phần mềm miễn phí'
                ],
                'icon' => 'crown',
                'button_text' => 'Chọn Gói',
                'button_icon' => 'star',
                'button_color' => 'warning',
                'is_popular' => true,
                'is_active' => true,
                'sort_order' => 2
            ],
            [
                'name' => 'Gói 24 Tháng',
                'duration' => '24 Tháng',
                'description' => 'Gói dịch vụ cao cấp với nhiều ưu đãi đặc biệt',
                'features' => [
                    'Tất cả dịch vụ gói 12 tháng',
                    'Tặng máy sau 24 tháng',
                    'Hỗ trợ kỹ thuật nhanh tại nơi',
                    'Hỗ trợ license phần mềm',
                    'Hỗ trợ 24/7',
                    'Ưu đãi đặc biệt'
                ],
                'icon' => 'diamond',
                'button_text' => 'Đăng Ký Ngay',
                'button_icon' => 'diamond',
                'button_color' => 'success',
                'is_popular' => false,
                'is_active' => true,
                'sort_order' => 3
            ]
        ];

        foreach ($packages as $packageData) {
            ServicePackage::create($packageData);
        }

        $this->command->info('Service packages seeded successfully!');
    }
}
