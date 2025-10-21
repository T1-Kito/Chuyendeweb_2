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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Customer details
            $table->string('customer_name');
            $table->string('customer_phone');
            $table->string('customer_email');
            $table->text('customer_address');
            $table->text('notes')->nullable();
            
            // Financial details
            $table->decimal('subtotal', 12, 2);
            $table->decimal('total_amount', 12, 2);
            $table->string('payment_method')->default('cash');
            $table->string('status')->default('pending');
            
            // Rental period
            $table->date('rental_start_date');
            $table->date('rental_end_date');
            $table->integer('total_months');
            
            $table->timestamps();
            
            // Indexes
            $table->index(['user_id', 'status']);
            $table->index('order_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
