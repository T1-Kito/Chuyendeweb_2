<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Thông tin thuê tối thiểu
            $table->integer('min_rental_months')->default(6)->comment('Số tháng thuê tối thiểu');
            
            // Giá theo gói thuê
            $table->decimal('price_6_months', 12, 2)->nullable()->comment('Giá thuê 6 tháng');
            $table->decimal('price_12_months', 12, 2)->nullable()->comment('Giá thuê 12 tháng');
            $table->decimal('price_18_months', 12, 2)->nullable()->comment('Giá thuê 18 tháng');
            $table->decimal('price_24_months', 12, 2)->nullable()->comment('Giá thuê 24 tháng');
            
            // Thông tin khuyến mãi
            $table->string('promotion_badge')->nullable()->comment('Badge khuyến mãi (Ưu đãi -10%, Sản phẩm nổi bật, etc.)');
            $table->text('promotion_description')->nullable()->comment('Mô tả chi tiết khuyến mãi');
            $table->date('promotion_start_date')->nullable()->comment('Ngày bắt đầu khuyến mãi');
            $table->date('promotion_end_date')->nullable()->comment('Ngày kết thúc khuyến mãi');
            
            // Thông tin bảo hành
            $table->string('warranty_info')->nullable()->comment('Thông tin bảo hành');
            $table->boolean('has_warranty_support')->default(false)->comment('Có hỗ trợ bảo hành');
            
            // Thông tin bổ sung
            $table->text('rental_terms')->nullable()->comment('Điều khoản thuê');
            $table->text('delivery_info')->nullable()->comment('Thông tin giao hàng');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'min_rental_months',
                'price_6_months',
                'price_12_months', 
                'price_18_months',
                'price_24_months',
                'promotion_badge',
                'promotion_description',
                'promotion_start_date',
                'promotion_end_date',
                'warranty_info',
                'has_warranty_support',
                'rental_terms',
                'delivery_info'
            ]);
        });
    }
};
