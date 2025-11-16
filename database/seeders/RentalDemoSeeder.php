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
            // Ensure we have a base category to attach demo products to
            $category = Category::firstOrCreate(
                ['slug' => 'thiet-bi-demo-cho-thue'],
                [
                    'name' => 'Thiết Bị Demo Cho Thuê',
                    'description' => 'Danh mục phục vụ dữ liệu demo khách thuê.',
                    'icon' => 'fas fa-cubes',
                    'color' => '#2563eb',
                    'is_active' => true,
                ]
            );

            $productTemplates = [
                [
                    'name' => 'Máy Chấm Công Demo X1',
                    'image' => 'products/demo-timekeeper.jpg',
                    'daily_price' => 45000,
                    'weekly_price' => 250000,
                    'monthly_price' => 850000,
                ],
                [
                    'name' => 'Camera Demo Quan Sát C2',
                    'image' => 'products/demo-camera.jpg',
                    'daily_price' => 60000,
                    'weekly_price' => 320000,
                    'monthly_price' => 980000,
                ],
                [
                    'name' => 'Máy In Demo Laser L3',
                    'image' => 'products/demo-printer.jpg',
                    'daily_price' => 70000,
                    'weekly_price' => 360000,
                    'monthly_price' => 1150000,
                ],
                [
                    'name' => 'Loa Sự Kiện Demo S4',
                    'image' => 'products/demo-speaker.jpg',
                    'daily_price' => 90000,
                    'weekly_price' => 420000,
                    'monthly_price' => 1350000,
                ],
            ];

            $products = collect();

            foreach ($productTemplates as $template) {
                $products->push(
                    Product::firstOrCreate(
                        ['slug' => Str::slug($template['name'])],
                        [
                            'name' => $template['name'],
                            'description' => 'Thiết bị demo phục vụ seed dữ liệu khách thuê.',
                            'features' => 'Thiết bị demo với đầy đủ tính năng cơ bản.',
                            'image' => $template['image'],
                            'category_id' => $category->id,
                            'daily_price' => $template['daily_price'],
                            'weekly_price' => $template['weekly_price'],
                            'monthly_price' => $template['monthly_price'],
                            'stock_quantity' => 5,
                            'status' => 'available',
                            'is_featured' => false,
                            'is_active' => true,
                            'min_rental_months' => 3,
                            'price_1_month' => $template['monthly_price'],
                            'price_6_months' => $template['monthly_price'] * 6 * 0.95,
                            'price_12_months' => $template['monthly_price'] * 12 * 0.9,
                            'price_18_months' => $template['monthly_price'] * 18 * 0.88,
                            'price_24_months' => $template['monthly_price'] * 24 * 0.85,
                            'promotion_badge' => null,
                            'promotion_description' => null,
                            'promotion_start_date' => null,
                            'promotion_end_date' => null,
                            'warranty_info' => 'Bảo hành demo 12 tháng.',
                            'has_warranty_support' => true,
                            'rental_terms' => 'Áp dụng cho mục đích demo nội bộ.',
                            'delivery_info' => 'Giao trong 48 giờ khu vực nội thành.',
                            'specs' => null,
                            'serial_number' => 'DEMO-' . Str::upper(Str::random(6)),
                            'model' => 'DEMO-' . Str::upper(Str::random(4)),
                        ]
                    )
                );
            }

            if ($products->isEmpty()) {
                return;
            }

            $tenantScenarios = [
                [
                    'order_number' => 'ORD-DEMO-001',
                    'customer' => [
                        'name' => 'Nguyễn Văn An',
                        'email' => 'tenant.active@example.com',
                        'phone' => '0901 234 567',
                        'address' => '123 Nguyễn Trãi, Hà Nội',
                    ],
                    'status' => 'processing',
                    'start' => Carbon::now()->subMonths(1),
                    'months' => 6,
                    'notes' => 'Khách đang thuê gói 6 tháng, còn khoảng 5 tháng.',
                ],
                [
                    'order_number' => 'ORD-DEMO-002',
                    'customer' => [
                        'name' => 'Trần Thị Bình',
                        'email' => 'tenant.expiring@example.com',
                        'phone' => '0902 345 678',
                        'address' => '456 Lê Lợi, Đà Nẵng',
                    ],
                    'status' => 'confirmed',
                    'start' => Carbon::now()->subMonths(5),
                    'months' => 6,
                    'end_override' => Carbon::now()->addDays(5),
                    'notes' => 'Khách sắp hết hạn thuê, cần liên hệ gia hạn.',
                ],
                [
                    'order_number' => 'ORD-DEMO-003',
                    'customer' => [
                        'name' => 'Phạm Minh Chi',
                        'email' => 'tenant.expired@example.com',
                        'phone' => '0903 456 789',
                        'address' => '789 Pasteur, TP.HCM',
                    ],
                    'status' => 'completed',
                    'start' => Carbon::now()->subMonths(14),
                    'months' => 12,
                    'end_override' => Carbon::now()->subMonths(2),
                    'notes' => 'Đơn thuê đã kết thúc, chờ thu hồi thiết bị.',
                ],
                [
                    'order_number' => 'ORD-DEMO-004',
                    'customer' => [
                        'name' => 'Lê Hoàng Dũng',
                        'email' => 'tenant.upcoming@example.com',
                        'phone' => '0904 567 890',
                        'address' => '12 Võ Văn Tần, Cần Thơ',
                    ],
                    'status' => 'confirmed',
                    'start' => Carbon::now()->addDays(10),
                    'months' => 3,
                    'notes' => 'Đơn thuê sẽ bắt đầu trong 10 ngày tới.',
                ],
            ];

            foreach ($tenantScenarios as $index => $data) {
                $user = User::firstOrCreate(
                    ['email' => $data['customer']['email']],
                    [
                        'name' => $data['customer']['name'],
                        'password' => Hash::make('password'),
                        'phone' => $data['customer']['phone'],
                        'address' => $data['customer']['address'],
                        'is_admin' => false,
                    ]
                );

                $startDate = $data['start']->copy();
                $months = $data['months'];
                $endDate = $data['end_override'] ?? $startDate->copy()->addMonths($months);

                $product = $products[$index % $products->count()];

                $monthlyRate = $product->price_1_month ?? $product->monthly_price ?? 600000;
                $quantity = 1;
                $subtotal = $monthlyRate * $months * $quantity;
                $totalMonths = max($months, $startDate->diffInMonths($endDate) ?: $months);

                $order = Order::updateOrCreate(
                    ['order_number' => $data['order_number']],
                    [
                        'user_id' => $user->id,
                        'customer_name' => $data['customer']['name'],
                        'customer_phone' => $data['customer']['phone'],
                        'customer_email' => $data['customer']['email'],
                        'customer_address' => $data['customer']['address'],
                        'notes' => $data['notes'],
                        'subtotal' => $subtotal,
                        'total_amount' => $subtotal,
                        'payment_method' => 'bank_transfer',
                        'status' => $data['status'],
                        'rental_start_date' => $startDate,
                        'rental_end_date' => $endDate,
                        'total_months' => $totalMonths,
                    ]
                );

                $order->items()->delete();

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
        });
    }
}
