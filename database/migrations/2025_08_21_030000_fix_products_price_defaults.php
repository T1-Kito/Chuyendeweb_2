<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Thêm giá trị mặc định cho các trường price cũ
            $table->decimal('daily_price', 12, 2)->default(0)->change();
            $table->decimal('weekly_price', 12, 2)->default(0)->change();
            $table->decimal('monthly_price', 12, 2)->default(0)->change();
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->decimal('daily_price', 12, 2)->nullable()->change();
            $table->decimal('weekly_price', 12, 2)->nullable()->change();
            $table->decimal('monthly_price', 12, 2)->nullable()->change();
        });
    }
};
