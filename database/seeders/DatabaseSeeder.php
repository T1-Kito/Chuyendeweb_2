<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            // 1. Seed admin users và permissions trước
            AdminUserSeeder::class,
            AdminPermissionSeeder::class,
            
            // 2. Seed users thường
            UserSeeder::class,
            
            // 3. Seed categories (không phụ thuộc)
            CategorySeeder::class,
            
            // 4. Seed products (phụ thuộc vào categories)
            ProductSeeder::class,
            
            // 5. Seed đánh giá và bình luận (phụ thuộc vào users và products)
            ReviewCommentSeeder::class,
            
            // 6. Seed các dữ liệu khác
            ServicePackageSeeder::class,
            VoucherSeeder::class,
            CheckInRewardSeeder::class,
            
            // 7. Seed dữ liệu demo (phụ thuộc vào users và products)
            CartSeeder::class,
            RentalDemoSeeder::class,
        ]);
    }
}
