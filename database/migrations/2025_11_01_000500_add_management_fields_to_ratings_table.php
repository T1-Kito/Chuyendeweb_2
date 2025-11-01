<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ratings', function (Blueprint $table) {
            $table->text('content')->nullable()->after('stars');
            $table->boolean('is_anonymous')->default(false)->after('content');
            $table->unsignedTinyInteger('package_months')->nullable()->after('is_anonymous');
            $table->string('status', 20)->default('pending')->index()->after('package_months');
            $table->timestamp('reviewed_at')->nullable()->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('ratings', function (Blueprint $table) {
            $table->dropColumn(['content', 'is_anonymous', 'package_months', 'status', 'reviewed_at']);
        });
    }
};
