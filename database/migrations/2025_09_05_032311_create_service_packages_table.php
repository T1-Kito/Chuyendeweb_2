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
        Schema::create('service_packages', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Tên gói (VD: Gói 6 Tháng)
            $table->string('duration'); // Thời gian (VD: 6 Tháng)
            $table->text('description')->nullable(); // Mô tả ngắn
            $table->json('features'); // Danh sách tính năng (array)
            $table->string('icon')->nullable(); // Icon (VD: clock, crown, diamond)
            $table->string('button_text')->default('Xem Chi Tiết'); // Text nút
            $table->string('button_icon')->nullable(); // Icon nút
            $table->string('button_color')->default('primary'); // Màu nút
            $table->boolean('is_popular')->default(false); // Gói phổ biến
            $table->boolean('is_active')->default(true); // Trạng thái hoạt động
            $table->integer('sort_order')->default(0); // Thứ tự sắp xếp
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_packages');
    }
};
