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
        Schema::create('check_ins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->date('check_in_date');
            $table->integer('day_number'); // Ngày thứ mấy trong chuỗi điểm danh
            $table->string('reward_type')->nullable(); // Loại phần thưởng: voucher, point, etc.
            $table->string('reward_value')->nullable(); // Giá trị phần thưởng: 10%, 15%, etc.
            $table->text('reward_description')->nullable(); // Mô tả phần thưởng
            $table->boolean('is_claimed')->default(false); // Đã nhận phần thưởng chưa
            $table->timestamp('claimed_at')->nullable(); // Thời gian nhận phần thưởng
            $table->timestamps();
            
            // Đảm bảo mỗi user chỉ điểm danh 1 lần/ngày
            $table->unique(['user_id', 'check_in_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('check_ins');
    }
};
