<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('users', 'two_factor_enabled')) {
            Schema::table('users', function (Blueprint $table) {
                $table->boolean('two_factor_enabled')->default(false)->after('address');
            });
        }

        if (! Schema::hasColumn('users', 'two_factor_code')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('two_factor_code')->nullable()->after('two_factor_enabled');
            });
        }

        if (! Schema::hasColumn('users', 'two_factor_expires_at')) {
            Schema::table('users', function (Blueprint $table) {
                $table->timestamp('two_factor_expires_at')->nullable()->after('two_factor_code');
            });
        }
    }

    public function down(): void
    {
        $columns = collect([
            'two_factor_enabled',
            'two_factor_code',
            'two_factor_expires_at',
        ])->filter(fn (string $column) => Schema::hasColumn('users', $column))->all();

        if (! empty($columns)) {
            Schema::table('users', function (Blueprint $table) use ($columns) {
                $table->dropColumn($columns);
            });
        }
    }
};
