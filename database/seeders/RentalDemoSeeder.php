<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RentalDemoSeeder extends Seeder
{
    /**
     * Seed demo rental orders so the admin tenants page has data.
     */
    public function run(): void
    {
        DB::transaction(function () {
            // Lấy tất cả categories đã tạo
            $categories = Category::with('products')->get();
            
            if ($categories->isEmpty()) {
                $this->command->warn('Không có category nào. Vui lòng chạy CategorySeeder trước.');
                return;
            }

            // Danh sách khách hàng demo
            $customers = [
                ['name' => 'Nguyễn Văn An', 'email' => 'nguyenvanan@example.com', 'phone' => '0901234567', 'address' => '123 Nguyễn Trãi, Hà Nội'],
                ['name' => 'Trần Thị Bình', 'email' => 'tranthibinh@example.com', 'phone' => '0902345678', 'address' => '456 Lê Lợi, Đà Nẵng'],
                ['name' => 'Phạm Minh Chi', 'email' => 'phamminhchi@example.com', 'phone' => '0903456789', 'address' => '789 Pasteur, TP.HCM'],
                ['name' => 'Lê Hoàng Dũng', 'email' => 'lehoangdung@example.com', 'phone' => '0904567890', 'address' => '12 Võ Văn Tần, Cần Thơ'],
                ['name' => 'Hoàng Thị Em', 'email' => 'hoangthiem@example.com', 'phone' => '0905678901', 'address' => '34 Trần Hưng Đạo, Hải Phòng'],
                ['name' => 'Vũ Văn Phong', 'email' => 'vuvanphong@example.com', 'phone' => '0906789012', 'address' => '56 Lý Thường Kiệt, Huế'],
                ['name' => 'Đỗ Thị Giang', 'email' => 'dothigiang@example.com', 'phone' => '0907890123', 'address' => '78 Hai Bà Trưng, Nha Trang'],
                ['name' => 'Bùi Văn Hải', 'email' => 'buivanha@example.com', 'phone' => '0908901234', 'address' => '90 Điện Biên Phủ, Vũng Tàu'],
                ['name' => 'Ngô Thị Lan', 'email' => 'ngothilan@example.com', 'phone' => '0909012345', 'address' => '11 Nguyễn Huệ, Quy Nhơn'],
                ['name' => 'Đinh Văn Khoa', 'email' => 'dinhvankhoa@example.com', 'phone' => '0910123456', 'address' => '22 Lê Duẩn, Vinh'],
                ['name' => 'Trương Thị Mai', 'email' => 'truongthimai@example.com', 'phone' => '0911234567', 'address' => '33 Phan Chu Trinh, Buôn Ma Thuột'],
                ['name' => 'Phan Văn Nam', 'email' => 'phanvannam@example.com', 'phone' => '0912345678', 'address' => '44 Quang Trung, Pleiku'],
                ['name' => 'Lý Thị Oanh', 'email' => 'lythioanh@example.com', 'phone' => '0913456789', 'address' => '55 Trường Chinh, Thái Nguyên'],
                ['name' => 'Võ Văn Phúc', 'email' => 'vovanphuc@example.com', 'phone' => '0914567890', 'address' => '66 Hùng Vương, Nam Định'],
                ['name' => 'Dương Thị Quỳnh', 'email' => 'duongthiquynh@example.com', 'phone' => '0915678901', 'address' => '77 Lạc Long Quân, Thanh Hóa'],
                ['name' => 'Tạ Văn Sơn', 'email' => 'tavanson@example.com', 'phone' => '0916789012', 'address' => '88 Bà Triệu, Nghệ An'],
                ['name' => 'Mai Thị Tâm', 'email' => 'maithitam@example.com', 'phone' => '0917890123', 'address' => '99 Cách Mạng Tháng 8, Hà Tĩnh'],
                ['name' => 'Hồ Văn Uy', 'email' => 'hovanuy@example.com', 'phone' => '0918901234', 'address' => '101 Lê Thánh Tông, Quảng Bình'],
            ];

            // Các trạng thái đơn hàng
            $statuses = ['pending', 'confirmed', 'processing', 'completed', 'cancelled'];
            
            // Các khoảng thời gian thuê (tháng)
            $rentalMonths = [3, 6, 9, 12, 18, 24];

            $orderNumber = 1;
            $customerIndex = 0;

            // Tạo 3 đơn hàng cho mỗi category
            foreach ($categories as $category) {
                $products = $category->products;
                
                if ($products->isEmpty()) {
                    $this->command->warn("Category '{$category->name}' không có sản phẩm nào.");
                    continue;
                }

                for ($i = 0; $i < 3; $i++) {
                    $customer = $customers[$customerIndex % count($customers)];
                    $customerIndex++;

                    // Tạo hoặc lấy user
                    $user = User::firstOrCreate(
                        ['email' => $customer['email']],
                        [
                            'name' => $customer['name'],
                            'password' => Hash::make('password'),
                            'phone' => $customer['phone'],
                            'address' => $customer['address'],
                            'is_admin' => false,
                        ]
                    );

                    // Chọn ngẫu nhiên sản phẩm từ category
                    $product = $products->random();
                    
                    // Chọn ngẫu nhiên trạng thái và số tháng
                    $status = $statuses[array_rand($statuses)];
                    $months = $rentalMonths[array_rand($rentalMonths)];
                    
                    // Tạo ngày bắt đầu ngẫu nhiên (từ 6 tháng trước đến 1 tháng sau)
                    $startDate = Carbon::now()->subMonths(rand(0, 6))->addDays(rand(-30, 30));
                    $endDate = $startDate->copy()->addMonths($months);

                    // Tính toán giá
                    $monthlyRate = $product->monthly_price ?? 600000;
                    $quantity = 1;
                    $subtotal = $monthlyRate * $months * $quantity;

                    // Tạo order
                    $order = Order::create([
                        'order_number' => 'ORD-' . str_pad($orderNumber++, 6, '0', STR_PAD_LEFT),
                        'user_id' => $user->id,
                        'customer_name' => $customer['name'],
                        'customer_phone' => $customer['phone'],
                        'customer_email' => $customer['email'],
                        'customer_address' => $customer['address'],
                        'notes' => "Đơn thuê {$product->name} trong {$months} tháng.",
                        'subtotal' => $subtotal,
                        'total_amount' => $subtotal,
                        'payment_method' => ['bank_transfer', 'cash', 'credit_card'][array_rand(['bank_transfer', 'cash', 'credit_card'])],
                        'status' => $status,
                        'rental_start_date' => $startDate,
                        'rental_end_date' => $endDate,
                        'total_months' => $months,
                    ]);

                    // Tạo order item
                    $order->items()->create([
                        'product_id' => $product->id,
                        'product_name' => $product->name,
                        'product_description' => $product->description,
                        'product_image' => $product->image,
                        'rental_duration_months' => $months,
                        'monthly_price' => $monthlyRate,
                        'total_price' => $subtotal,
                        'quantity' => $quantity,
                    ]);
                }
            }

            $this->command->info('Đã tạo ' . ($orderNumber - 1) . ' đơn hàng demo thành công!');
        });
    }
}
