<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'Máy Chấm Công Vân Tay ZKTeco C3X',
                'description' => 'Máy chấm công vân tay hiện đại, hỗ trợ 3000 vân tay, màn hình cảm ứng 2.4 inch',
                'features' => 'Vân tay, màn hình cảm ứng, kết nối USB, hỗ trợ 3000 vân tay',
                'image' => 'products/time-clock-1.jpg',
                'slug' => 'may-cham-cong-van-tay-zkteco-c3x',
                'category_id' => 1,
                'daily_price' => 50000,
                'weekly_price' => 300000,
                'monthly_price' => 1000000,
                'stock_quantity' => 10,
                'is_featured' => true
            ],
            [
                'name' => 'Camera IP Dome Hikvision DS-2CD2142FWD-I',
                'description' => 'Camera IP dome 4MP, tầm nhìn ban đêm 30m, chống nước IP67',
                'features' => '4MP, tầm nhìn ban đêm, chống nước IP67, hỗ trợ PoE',
                'image' => 'products/camera-1.jpg',
                'slug' => 'camera-ip-dome-hikvision-ds-2cd2142fwd-i',
                'category_id' => 2,
                'daily_price' => 80000,
                'weekly_price' => 450000,
                'monthly_price' => 1500000,
                'stock_quantity' => 15,
                'is_featured' => true
            ],
            [
                'name' => 'Máy In Laser HP LaserJet Pro M404n',
                'description' => 'Máy in laser đen trắng, tốc độ in 40 trang/phút, kết nối mạng',
                'features' => 'Laser đen trắng, 40 trang/phút, kết nối mạng, khay giấy 250 tờ',
                'image' => 'products/printer-1.jpg',
                'slug' => 'may-in-laser-hp-laserjet-pro-m404n',
                'category_id' => 3,
                'daily_price' => 60000,
                'weekly_price' => 350000,
                'monthly_price' => 1200000,
                'stock_quantity' => 8,
                'is_featured' => false
            ],
            [
                'name' => 'Loa Line Array JBL VTX A8',
                'description' => 'Loa line array chuyên nghiệp, công suất cao, âm thanh trong trẻo',
                'features' => 'Line array, công suất cao, âm thanh trong trẻo, dễ lắp đặt',
                'image' => 'products/speaker-1.jpg',
                'slug' => 'loa-line-array-jbl-vtx-a8',
                'category_id' => 4,
                'daily_price' => 200000,
                'weekly_price' => 1200000,
                'monthly_price' => 4000000,
                'stock_quantity' => 4,
                'is_featured' => true
            ]
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
