<?php

namespace Database\Seeders;

use App\Models\Cart;
use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Xóa dữ liệu cũ nếu có
        DB::table('carts')->truncate();

        // Lấy tất cả user (trừ admin)
        $users = User::where('is_admin', false)->get();

        if ($users->isEmpty()) {
            $this->command->warn('Không có user nào. Vui lòng tạo user trước.');
            return;
        }

        // Lấy tất cả sản phẩm đang active
        $products = Product::where('is_active', true)->get();

        if ($products->isEmpty()) {
            $this->command->warn('Không có sản phẩm nào. Vui lòng chạy ProductSeeder trước.');
            return;
        }

        $rentalDurations = [1, 6, 12, 18, 24];
        $cartCount = 0;

        // Tạo giỏ hàng cho mỗi user (mỗi user có 1-5 sản phẩm trong giỏ)
        foreach ($users as $user) {
            $itemCount = rand(1, 5);
            $selectedProducts = $products->random(min($itemCount, $products->count()));

            foreach ($selectedProducts as $product) {
                $rentalDuration = $rentalDurations[array_rand($rentalDurations)];
                $pricePerMonth = $product->getPriceByMonths($rentalDuration);

                if (!$pricePerMonth || $pricePerMonth <= 0) {
                    continue; // Bỏ qua sản phẩm không có giá
                }

                // Số lượng ngẫu nhiên, không vượt quá stock
                $maxQuantity = min(5, $product->stock_quantity ?? 5);
                $quantity = rand(1, max(1, $maxQuantity));

                Cart::create([
                    'user_id' => $user->id,
                    'product_id' => $product->id,
                    'rental_duration' => $rentalDuration,
                    'quantity' => $quantity,
                    'price_per_month' => $pricePerMonth,
                    'total_price' => $pricePerMonth * $quantity,
                ]);

                $cartCount++;
            }
        }

        $this->command->info("Đã tạo {$cartCount} sản phẩm trong giỏ hàng cho " . $users->count() . " user.");
    }
}

