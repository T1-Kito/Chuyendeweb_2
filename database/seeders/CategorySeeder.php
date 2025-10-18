<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Máy Chấm Công',
                'description' => 'Các loại máy chấm công vân tay, thẻ từ, nhận diện khuôn mặt',
                'icon' => 'fas fa-fingerprint',
                'color' => '#2563eb',
                'is_active' => true,
            ],
            [
                'name' => 'Cổng Barrier',
                'description' => 'Cổng barrier tự động kiểm soát xe ra vào',
                'icon' => 'fas fa-gate',
                'color' => '#059669',
                'is_active' => true,
            ],
            [
                'name' => 'Camera Giám Sát',
                'description' => 'Hệ thống camera giám sát an ninh',
                'icon' => 'fas fa-video',
                'color' => '#dc2626',
                'is_active' => true,
            ],
            [
                'name' => 'Hệ Thống Nhận Diện',
                'description' => 'Hệ thống nhận diện khuôn mặt, biển số xe',
                'icon' => 'fas fa-user-shield',
                'color' => '#7c3aed',
                'is_active' => true,
            ],
            [
                'name' => 'Thiết Bị Báo Cháy',
                'description' => 'Hệ thống báo cháy và phòng cháy chữa cháy',
                'icon' => 'fas fa-fire-extinguisher',
                'color' => '#ea580c',
                'is_active' => true,
            ],
            [
                'name' => 'Thiết Bị Mạng',
                'description' => 'Switch, router, access point cho hệ thống mạng',
                'icon' => 'fas fa-network-wired',
                'color' => '#0891b2',
                'is_active' => true,
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        $this->command->info('Categories seeded successfully!');
    }
}
