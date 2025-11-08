<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Voucher;

class VoucherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vouchers = [
            [
                'code' => 'WELCOME10',
                'name' => 'Chào mừng khách hàng mới',
                'description' => 'Giảm 10% cho đơn hàng đầu tiên',
                'type' => 'percentage',
                'value' => 10.00,
                'min_order_amount' => 100000.00,
                'max_discount' => 50000.00,
                'usage_limit' => 100,
                'starts_at' => now(),
                'expires_at' => now()->addMonths(3),
                'is_active' => true,
            ],
            [
                'code' => 'SAVE50K',
                'name' => 'Tiết kiệm 50k',
                'description' => 'Giảm 50,000đ cho đơn hàng từ 500,000đ',
                'type' => 'fixed',
                'value' => 50000.00,
                'min_order_amount' => 500000.00,
                'usage_limit' => 50,
                'starts_at' => now(),
                'expires_at' => now()->addMonths(2),
                'is_active' => true,
            ],
            [
                'code' => 'VIP15',
                'name' => 'Khách hàng VIP',
                'description' => 'Giảm 15% cho khách hàng VIP',
                'type' => 'percentage',
                'value' => 15.00,
                'min_order_amount' => 200000.00,
                'max_discount' => 100000.00,
                'usage_limit' => 20,
                'starts_at' => now(),
                'expires_at' => now()->addMonths(6),
                'is_active' => true,
            ],
            [
                'code' => 'SUMMER20',
                'name' => 'Khuyến mãi mùa hè',
                'description' => 'Giảm 20% cho tất cả sản phẩm mùa hè',
                'type' => 'percentage',
                'value' => 20.00,
                'min_order_amount' => 300000.00,
                'max_discount' => 200000.00,
                'usage_limit' => 30,
                'starts_at' => now(),
                'expires_at' => now()->addMonths(1),
                'is_active' => true,
            ],
            [
                'code' => 'FREESHIP',
                'name' => 'Miễn phí vận chuyển',
                'description' => 'Miễn phí vận chuyển cho đơn hàng từ 200,000đ',
                'type' => 'fixed',
                'value' => 30000.00,
                'min_order_amount' => 200000.00,
                'usage_limit' => 100,
                'starts_at' => now(),
                'expires_at' => now()->addMonths(2),
                'is_active' => true,
            ],
            [
                'code' => 'NEWYEAR25',
                'name' => 'Chào năm mới',
                'description' => 'Giảm 25% cho đơn hàng năm mới',
                'type' => 'percentage',
                'value' => 25.00,
                'min_order_amount' => 500000.00,
                'max_discount' => 300000.00,
                'usage_limit' => 15,
                'starts_at' => now()->addDays(30),
                'expires_at' => now()->addDays(60),
                'is_active' => false,
            ],
        ];

        foreach ($vouchers as $voucherData) {
            Voucher::create($voucherData);
        }

        $this->command->info('Voucher mẫu đã được tạo thành công!');
    }
}
