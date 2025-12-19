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
        Schema::table('subscription_plans', function (Blueprint $table) {
            // Tambahkan kolom kategori
            $table->string('category_subscription')->default('bulanan')->after('description');

            // Tambahkan index untuk performa query
            $table->index('category_subscription');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subscription_plans', function (Blueprint $table) {
            $table->dropIndex(['category_subscription']);
            $table->dropColumn('category_subscription');
        });
    }
};
