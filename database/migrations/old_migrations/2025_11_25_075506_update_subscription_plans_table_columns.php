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
            // Drop old columns
            $table->dropColumn(['price_monthly', 'price_annual', 'max_books', 'order_index']);

            // Add new columns
            $table->string('slug')->after('name')->unique();
            $table->decimal('price', 10, 2)->after('description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subscription_plans', function (Blueprint $table) {
            // Restore old columns
            $table->decimal('price_monthly', 10, 2)->nullable()->after('description');
            $table->decimal('price_annual', 10, 2)->nullable()->after('price_monthly');
            $table->integer('max_books')->nullable()->after('features');
            $table->integer('order_index')->default(0)->after('is_active');

            // Drop new columns
            $table->dropColumn(['slug', 'price']);
        });
    }
};
