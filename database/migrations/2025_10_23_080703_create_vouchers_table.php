<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // Mã voucher
            $table->string('name'); // Tên voucher
            $table->text('description')->nullable(); // Mô tả
            $table->enum('type', ['percentage', 'fixed']); // Loại: phần trăm hoặc số tiền cố định
            $table->decimal('value', 10, 2); // Giá trị (10% hoặc 50000đ)
            $table->decimal('min_order_amount', 10, 2)->nullable(); // Đơn hàng tối thiểu
            $table->decimal('max_discount', 10, 2)->nullable(); // Giảm tối đa
            $table->integer('usage_limit')->nullable(); // Giới hạn sử dụng
            $table->integer('used_count')->default(0); // Đã sử dụng
            $table->datetime('starts_at')->nullable(); // Bắt đầu từ
            $table->datetime('expires_at')->nullable(); // Hết hạn
            $table->boolean('is_active')->default(true); // Trạng thái
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vouchers');
    }
};
