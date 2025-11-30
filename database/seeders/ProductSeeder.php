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
        // Lấy danh sách hình ảnh từ thư mục storage/app/public/products
        $images = [
            '0EUMvp0H45O1QBEy8JPK46Z59FtY4UKEFIr0zGsF.jpg',
            '1xwa8ZN9vuO1X4Z3xfMh065RWO5jbf2g4EOFqWVv.jpg',
            '5v5DMzuVoHA21wA9pmVqbkqgji3jm2LA21StXt5u.jpg',
            '8Ph2jBo5nub7GoLg7btwVxuG2z13qDNVCq3ZuVna.jpg',
            'BJ8mccPz1bseCaNy0YosJgP4xvs9kJ2GZ8XWcrOQ.jpg',
            'C2EzFUrJE3M0GVUQpTeWhSwpPhZbCShKMWBME0zS.jpg',
            'Hl7ThmxvFkAQqZlUC63j1Hjmk2vCwlTJpWuutVEW.jpg',
            'IZXHxqyHTwy18ZAhDWSMGg9JDVeUjSdkZ4qugVIu.jpg',
            'Iod19NHEEOPTiPuFZv2Pl3nC9qapm9WlvZaWh2sp.jpg',
            'Kh8UbrWOwfSERbFpbFRi5LhxkCWrAvdZVKsIgMCW.jpg',
            'LaeKmNXdZnhzSzMwkjEDd3ewe2UD4SY30uXpKhuR.jpg',
            'TB9NB0ktiUUFCunxjRPVorA8ygZSsxgui02BbWbz.jpg',
            'V0OrZ6CbK6pypbbPYqdQaab9AIlw9vDURpkRWO6L.jpg',
            'WBMiivXtp6eFS9Ab4CtIOJzywOl6gy0ygLx3xldN.jpg',
            'ZSoObsvVPkFgzgxwSA8HWwt8EvfvTdDCC1bbMViO.jpg',
            'd0ldNFjc2m0RgHEfDC8VMnlF7KY3TX3XKtedI0Sv.jpg',
            'fxws1FjL1EWeqUIISW85zIKg4UI0NsYkAqSC4z6Z.jpg',
            'i1eI2YxcrkNE6EWWZTGhKXUWZ0l9k8YmTxe9tz3v.jpg',
            'knztHufEnOJpR5aD075cBiL30oDc5A0D22nwWx5a.jpg',
            'mhcWSexftxR6ys6qfeIkeJMkOraMKHGKACnE8vc7.jpg',
            'rHbGEkU6EjxERpG9hrdOsKbCP2YrSBtTcIBf66fO.jpg',
            'uLVO3R6LATtpTxTX0eLSjrCVemLqoyNx9aOdfuoZ.jpg',
            'vK7SCgRA3m6gU32bleE2I6WOulAWGk8YFw5I973C.jpg',
            'w9n5QRgLOcrb8M2AAvq2cVowxzJP8aPCzSW5vhn2.jpg',
        ];

        // Định nghĩa sản phẩm cho từng category
        $productTemplates = [
            // Category 1: Máy Chấm Công
            1 => [
                ['name' => 'Máy Chấm Công Vân Tay ZKTeco C3X', 'description' => 'Máy chấm công vân tay hiện đại, hỗ trợ 3000 vân tay, màn hình cảm ứng 2.4 inch', 'features' => 'Vân tay, màn hình cảm ứng, kết nối USB', 'daily_price' => 50000, 'weekly_price' => 300000, 'monthly_price' => 1000000, 'stock_quantity' => 10],
                ['name' => 'Máy Chấm Công Thẻ Từ Ronald Jack X628C', 'description' => 'Máy chấm công thẻ từ tin cậy, dễ sử dụng, hỗ trợ 2000 thẻ', 'features' => 'Thẻ từ, dễ sử dụng, kết nối USB', 'daily_price' => 40000, 'weekly_price' => 250000, 'monthly_price' => 850000, 'stock_quantity' => 12],
                ['name' => 'Máy Chấm Công Khuôn Mặt Hikvision DS-K1T341AMF', 'description' => 'Máy chấm công nhận diện khuôn mặt, chính xác cao, tốc độ nhanh', 'features' => 'Nhận diện khuôn mặt, chính xác cao, màn hình 7 inch', 'daily_price' => 80000, 'weekly_price' => 500000, 'monthly_price' => 1800000, 'stock_quantity' => 8],
                ['name' => 'Máy Chấm Công Vân Tay + Thẻ ZKTeco K40', 'description' => 'Máy chấm công kết hợp vân tay và thẻ từ, linh hoạt sử dụng', 'features' => 'Vân tay + Thẻ từ, màn hình màu, kết nối mạng', 'daily_price' => 60000, 'weekly_price' => 350000, 'monthly_price' => 1200000, 'stock_quantity' => 15],
                ['name' => 'Máy Chấm Công Vân Tay Wise Eye WSE-810', 'description' => 'Máy chấm công vân tay giá rẻ, phù hợp doanh nghiệp nhỏ', 'features' => 'Vân tay, giá rẻ, dễ cài đặt', 'daily_price' => 35000, 'weekly_price' => 200000, 'monthly_price' => 700000, 'stock_quantity' => 20],
            ],
            // Category 2: Cổng Barrier
            2 => [
                ['name' => 'Cổng Barrier Tự Động FAAC 615', 'description' => 'Cổng barrier tự động chuyên nghiệp, thanh chắn 5m, động cơ bền bỉ', 'features' => 'Thanh chắn 5m, động cơ mạnh mẽ, chống va đập', 'daily_price' => 150000, 'weekly_price' => 900000, 'monthly_price' => 3000000, 'stock_quantity' => 5],
                ['name' => 'Cổng Barrier Tự Động Nice M-BAR', 'description' => 'Cổng barrier cao cấp, thanh chắn 4m, tích hợp LED', 'features' => 'Thanh chắn 4m, LED cảnh báo, remote điều khiển', 'daily_price' => 120000, 'weekly_price' => 750000, 'monthly_price' => 2500000, 'stock_quantity' => 6],
                ['name' => 'Cổng Barrier Tự Động BFT Moovi', 'description' => 'Cổng barrier nhập khẩu Ý, thanh chắn 3m, thiết kế đẹp', 'features' => 'Thanh chắn 3m, thiết kế Ý, độ bền cao', 'daily_price' => 100000, 'weekly_price' => 600000, 'monthly_price' => 2000000, 'stock_quantity' => 8],
                ['name' => 'Cổng Barrier Tự Động Came Gard', 'description' => 'Cổng barrier tự động, thanh chắn 6m, phù hợp bãi xe lớn', 'features' => 'Thanh chắn 6m, công suất lớn, bảo hành 2 năm', 'daily_price' => 180000, 'weekly_price' => 1100000, 'monthly_price' => 3500000, 'stock_quantity' => 4],
                ['name' => 'Cổng Barrier Tự Động Doorking 1601', 'description' => 'Cổng barrier giá rẻ, thanh chắn 3.5m, dễ lắp đặt', 'features' => 'Thanh chắn 3.5m, giá tốt, lắp đặt nhanh', 'daily_price' => 90000, 'weekly_price' => 550000, 'monthly_price' => 1800000, 'stock_quantity' => 10],
            ],
            // Category 3: Camera Giám Sát
            3 => [
                ['name' => 'Camera IP Dome Hikvision DS-2CD2142FWD-I', 'description' => 'Camera IP dome 4MP, tầm nhìn ban đêm 30m, chống nước IP67', 'features' => '4MP, tầm nhìn ban đêm 30m, chống nước IP67', 'daily_price' => 80000, 'weekly_price' => 450000, 'monthly_price' => 1500000, 'stock_quantity' => 15],
                ['name' => 'Camera IP Bullet Dahua IPC-HFW1230S', 'description' => 'Camera IP bullet 2MP, hồng ngoại 80m, chống ngược sáng', 'features' => '2MP, hồng ngoại 80m, WDR', 'daily_price' => 60000, 'weekly_price' => 350000, 'monthly_price' => 1200000, 'stock_quantity' => 20],
                ['name' => 'Camera PTZ Hikvision DS-2DE4A425IWG-E', 'description' => 'Camera PTZ 4MP, zoom quang 25x, xoay 360 độ', 'features' => '4MP, zoom 25x, xoay 360°, tự động theo dõi', 'daily_price' => 200000, 'weekly_price' => 1200000, 'monthly_price' => 4000000, 'stock_quantity' => 5],
                ['name' => 'Camera Wifi Ezviz C6N', 'description' => 'Camera wifi trong nhà, 2MP, xoay 360 độ, đàm thoại 2 chiều', 'features' => '2MP, wifi, xoay 360°, đàm thoại 2 chiều', 'daily_price' => 40000, 'weekly_price' => 250000, 'monthly_price' => 850000, 'stock_quantity' => 25],
                ['name' => 'Camera Analog Hikvision DS-2CE16D0T-IR', 'description' => 'Camera analog 2MP, hồng ngoại 20m, giá rẻ', 'features' => '2MP, hồng ngoại 20m, giá tốt', 'daily_price' => 30000, 'weekly_price' => 180000, 'monthly_price' => 600000, 'stock_quantity' => 30],
            ],
            // Category 4: Hệ Thống Nhận Diện
            4 => [
                ['name' => 'Hệ Thống Nhận Diện Khuôn Mặt ZKTeco ProFace X', 'description' => 'Hệ thống nhận diện khuôn mặt AI, chính xác 99.9%, tốc độ 0.2s', 'features' => 'AI, chính xác 99.9%, tốc độ 0.2s, màn hình 7 inch', 'daily_price' => 150000, 'weekly_price' => 900000, 'monthly_price' => 3000000, 'stock_quantity' => 8],
                ['name' => 'Hệ Thống Nhận Diện Biển Số Xe Hikvision', 'description' => 'Camera nhận diện biển số xe, tự động mở cổng, lưu trữ dữ liệu', 'features' => 'Nhận diện biển số, tự động mở cổng, lưu trữ', 'daily_price' => 180000, 'weekly_price' => 1100000, 'monthly_price' => 3500000, 'stock_quantity' => 6],
                ['name' => 'Máy Chấm Công Nhận Diện Khuôn Mặt + Vân Tay', 'description' => 'Thiết bị nhận diện kết hợp khuôn mặt và vân tay, đa chức năng', 'features' => 'Khuôn mặt + Vân tay, màn hình cảm ứng, wifi', 'daily_price' => 100000, 'weekly_price' => 600000, 'monthly_price' => 2000000, 'stock_quantity' => 12],
                ['name' => 'Hệ Thống Kiểm Soát Ra Vào Thẻ Từ + Khuôn Mặt', 'description' => 'Hệ thống kiểm soát ra vào kết hợp thẻ từ và nhận diện khuôn mặt', 'features' => 'Thẻ từ + Khuôn mặt, kết nối mạng, báo cáo chi tiết', 'daily_price' => 120000, 'weekly_price' => 750000, 'monthly_price' => 2500000, 'stock_quantity' => 10],
                ['name' => 'Camera AI Nhận Diện Hành Vi', 'description' => 'Camera AI nhận diện hành vi bất thường, cảnh báo tự động', 'features' => 'AI, nhận diện hành vi, cảnh báo tự động', 'daily_price' => 200000, 'weekly_price' => 1200000, 'monthly_price' => 4000000, 'stock_quantity' => 5],
            ],
            // Category 5: Thiết Bị Báo Cháy
            5 => [
                ['name' => 'Đầu Báo Khói Quang Học Hochiki', 'description' => 'Đầu báo khói quang học nhạy, phát hiện sớm, độ tin cậy cao', 'features' => 'Quang học, nhạy, độ tin cậy cao', 'daily_price' => 30000, 'weekly_price' => 180000, 'monthly_price' => 600000, 'stock_quantity' => 50],
                ['name' => 'Đầu Báo Nhiệt Hochiki', 'description' => 'Đầu báo nhiệt chính xác, phù hợp nhà bếp, nhà xưởng', 'features' => 'Báo nhiệt, chính xác, phù hợp nhà bếp', 'daily_price' => 25000, 'weekly_price' => 150000, 'monthly_price' => 500000, 'stock_quantity' => 60],
                ['name' => 'Trung Tâm Báo Cháy Hochiki 8 Zone', 'description' => 'Trung tâm báo cháy 8 zone, màn hình LCD, dễ quản lý', 'features' => '8 zone, màn hình LCD, dễ quản lý', 'daily_price' => 150000, 'weekly_price' => 900000, 'monthly_price' => 3000000, 'stock_quantity' => 8],
                ['name' => 'Nút Ấn Khẩn Cấp Báo Cháy', 'description' => 'Nút ấn khẩn cấp báo cháy, kích hoạt thủ công, chắc chắn', 'features' => 'Kích hoạt thủ công, chắc chắn, dễ sử dụng', 'daily_price' => 20000, 'weekly_price' => 120000, 'monthly_price' => 400000, 'stock_quantity' => 80],
                ['name' => 'Chuông Báo Cháy + Đèn Chớp', 'description' => 'Chuông báo cháy kết hợp đèn chớp, âm thanh lớn, dễ nhận biết', 'features' => 'Chuông + Đèn chớp, âm thanh lớn', 'daily_price' => 35000, 'weekly_price' => 200000, 'monthly_price' => 700000, 'stock_quantity' => 40],
            ],
            // Category 6: Thiết Bị Mạng
            6 => [
                ['name' => 'Switch PoE 8 Port Cisco SG250-08HP', 'description' => 'Switch PoE 8 port, hỗ trợ camera IP, quản lý thông minh', 'features' => '8 port PoE, quản lý, 65W', 'daily_price' => 80000, 'weekly_price' => 450000, 'monthly_price' => 1500000, 'stock_quantity' => 15],
                ['name' => 'Router Wifi 6 TP-Link Archer AX73', 'description' => 'Router wifi 6, tốc độ cao, phủ sóng rộng, ổn định', 'features' => 'Wifi 6, tốc độ cao, phủ sóng rộng', 'daily_price' => 50000, 'weekly_price' => 300000, 'monthly_price' => 1000000, 'stock_quantity' => 20],
                ['name' => 'Access Point Ubiquiti UniFi AC Pro', 'description' => 'Access point chuyên nghiệp, phủ sóng rộng, quản lý tập trung', 'features' => 'Phủ sóng rộng, quản lý tập trung, PoE', 'daily_price' => 60000, 'weekly_price' => 350000, 'monthly_price' => 1200000, 'stock_quantity' => 18],
                ['name' => 'Switch 24 Port Gigabit TP-Link TL-SG1024D', 'description' => 'Switch 24 port gigabit, không quản lý, giá tốt', 'features' => '24 port gigabit, không quản lý, giá tốt', 'daily_price' => 40000, 'weekly_price' => 250000, 'monthly_price' => 850000, 'stock_quantity' => 25],
                ['name' => 'Firewall Fortinet FortiGate 60E', 'description' => 'Firewall bảo mật cao, chống virus, lọc web, VPN', 'features' => 'Bảo mật cao, chống virus, lọc web, VPN', 'daily_price' => 200000, 'weekly_price' => 1200000, 'monthly_price' => 4000000, 'stock_quantity' => 5],
            ],
        ];

        $imageIndex = 0;
        
        // Tạo 5 sản phẩm cho mỗi category
        foreach ($productTemplates as $categoryId => $products) {
            foreach ($products as $index => $productData) {
                // Tạo slug từ tên sản phẩm
                $slug = \Illuminate\Support\Str::slug($productData['name']);
                
                Product::create([
                    'name' => $productData['name'],
                    'description' => $productData['description'],
                    'features' => $productData['features'],
                    'image' => 'products/' . $images[$imageIndex % count($images)],
                    'slug' => $slug,
                    'category_id' => $categoryId,
                    'daily_price' => $productData['daily_price'],
                    'weekly_price' => $productData['weekly_price'],
                    'monthly_price' => $productData['monthly_price'],
                    'stock_quantity' => $productData['stock_quantity'],
                    'is_featured' => $index === 0 // Sản phẩm đầu tiên của mỗi category là featured
                ]);
                
                $imageIndex++;
            }
        }

        $this->command->info('Products seeded successfully! Created 30 products (5 per category).');
    }
}
