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
        // Tambahkan index untuk pencarian cepat di webhook
        Schema::table('subscription_plans', function (Blueprint $table) {
            $table->index('name', 'idx_subscription_plans_name');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->index('email', 'idx_users_email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Hapus index jika rollback
        Schema::table('subscription_plans', function (Blueprint $table) {
            $table->dropIndex('idx_subscription_plans_name');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex('idx_users_email');
        });
    }
};
