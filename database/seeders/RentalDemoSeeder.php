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

            // Lấy tất cả users thường (không phải admin) đã có
            $users = User::where('is_admin', false)->get();
            
            if ($users->isEmpty()) {
                $this->command->warn('Không có user nào. Vui lòng chạy UserSeeder trước.');
                return;
            }

            // Các trạng thái đơn hàng
            $statuses = ['pending', 'confirmed', 'processing', 'completed', 'cancelled'];
            
            // Các khoảng thời gian thuê (tháng)
            $rentalMonths = [3, 6, 9, 12, 18, 24];

            $orderNumber = 1;
            $userIndex = 0;

            // Tạo 3 đơn hàng cho mỗi category
            foreach ($categories as $category) {
                $products = $category->products;
                
                if ($products->isEmpty()) {
                    $this->command->warn("Category '{$category->name}' không có sản phẩm nào.");
                    continue;
                }

                for ($i = 0; $i < 3; $i++) {
                    // Lấy user theo vòng lặp
                    $user = $users[$userIndex % $users->count()];
                    $userIndex++;

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
                        'customer_name' => $user->name,
                        'customer_phone' => $user->phone,
                        'customer_email' => $user->email,
                        'customer_address' => $user->address,
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
