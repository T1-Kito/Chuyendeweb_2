<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Product;
use App\Models\Rating;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ReviewCommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Lấy tất cả users thường (không phải admin)
        $users = User::where('is_admin', false)->get();
        
        if ($users->isEmpty()) {
            $this->command->warn('Không có user nào. Vui lòng chạy UserSeeder trước.');
            return;
        }

        // Lấy tất cả products
        $products = Product::all();
        
        if ($products->isEmpty()) {
            $this->command->warn('Không có product nào. Vui lòng chạy ProductSeeder trước.');
            return;
        }

        // Nội dung đánh giá mẫu
        $reviewContents = [
            'Sản phẩm rất tốt, chất lượng đúng như mô tả. Tôi rất hài lòng với sản phẩm này.',
            'Thiết bị hoạt động ổn định, giao hàng nhanh chóng. Sẽ tiếp tục thuê thêm.',
            'Chất lượng tốt, giá cả hợp lý. Nhân viên tư vấn nhiệt tình.',
            'Sản phẩm đáp ứng đúng nhu cầu công việc. Rất đáng để thuê.',
            'Thiết bị mới, hoạt động tốt. Dịch vụ giao nhận chuyên nghiệp.',
            'Sản phẩm chất lượng cao, đóng gói cẩn thận. Tôi rất hài lòng.',
            'Thiết bị hoạt động ổn định, không có vấn đề gì. Giá thuê hợp lý.',
            'Chất lượng tốt, phù hợp với công việc. Sẽ giới thiệu cho bạn bè.',
            'Sản phẩm đúng như mô tả, giao hàng đúng hẹn. Rất tốt!',
            'Thiết bị chất lượng, dễ sử dụng. Dịch vụ hỗ trợ tốt.',
            'Sản phẩm hoạt động ổn, giá cả phải chăng. Đáng để thuê.',
            'Chất lượng sản phẩm tốt, nhân viên hỗ trợ nhiệt tình.',
            'Thiết bị mới, đầy đủ tính năng. Tôi rất hài lòng với lựa chọn này.',
            'Sản phẩm tốt, giao hàng nhanh. Sẽ thuê thêm lần sau.',
            'Chất lượng đáng tin cậy, giá thuê hợp lý. Rất hài lòng.',
        ];

        // Nội dung bình luận mẫu
        $commentContents = [
            'Sản phẩm này có hỗ trợ giao hàng tận nơi không ạ?',
            'Cho mình hỏi sản phẩm này còn hàng không?',
            'Giá thuê có thể thương lượng được không?',
            'Sản phẩm này có bảo hành không ạ?',
            'Mình muốn thuê dài hạn thì có ưu đãi gì không?',
            'Sản phẩm này phù hợp cho văn phòng nhỏ không?',
            'Có hỗ trợ lắp đặt tại chỗ không ạ?',
            'Cho mình xem thêm hình ảnh thực tế được không?',
            'Sản phẩm này có dễ sử dụng không?',
            'Thời gian giao hàng khoảng bao lâu ạ?',
            'Có thể thuê theo ngày được không?',
            'Sản phẩm này có tính năng gì nổi bật?',
            'Mình có thể xem trực tiếp sản phẩm không?',
            'Giá này đã bao gồm phí vận chuyển chưa?',
            'Có chính sách đổi trả không ạ?',
        ];

        $ratingCount = 0;
        $commentCount = 0;

        foreach ($users as $user) {
            // Chọn 3 sản phẩm ngẫu nhiên không trùng lặp cho đánh giá
            $ratingProducts = $products->random(min(3, $products->count()));
            
            // Tạo 3 đánh giá ngẫu nhiên cho mỗi user
            foreach ($ratingProducts as $product) {
                $stars = rand(3, 5); // Đánh giá từ 3-5 sao
                $content = $reviewContents[array_rand($reviewContents)];
                
                // Thêm thêm nội dung ngẫu nhiên để đa dạng hơn
                if (rand(0, 1)) {
                    $content .= ' ' . $reviewContents[array_rand($reviewContents)];
                }

                Rating::create([
                    'product_id' => $product->id,
                    'user_id' => $user->id,
                    'stars' => $stars,
                    'content' => $content,
                    'is_anonymous' => rand(0, 10) < 3, // 30% ẩn danh
                    'package_months' => [3, 6, 12][array_rand([3, 6, 12])],
                    'status' => ['approved', 'approved', 'approved', 'pending'][array_rand(['approved', 'approved', 'approved', 'pending'])], // 75% approved
                    'reviewed_at' => Carbon::now()->subDays(rand(1, 90)),
                ]);
                
                $ratingCount++;
            }

            // Tạo 3 bình luận ngẫu nhiên cho mỗi user
            for ($i = 0; $i < 3; $i++) {
                $product = $products->random();
                $content = $commentContents[array_rand($commentContents)];

                Comment::create([
                    'product_id' => $product->id,
                    'user_id' => $user->id,
                    'content' => $content,
                    'parent_id' => null,
                    'created_at' => Carbon::now()->subDays(rand(1, 60)),
                ]);
                
                $commentCount++;
            }
        }

        $this->command->info("Đã tạo {$ratingCount} đánh giá và {$commentCount} bình luận thành công!");
    }
}
