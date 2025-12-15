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
            // Tambahkan kolom jika belum ada, untuk mencegah error
            if (!Schema::hasColumn('subscription_plans', 'price_description')) {
                $table->string('price_description')->nullable()->after('price');
            }
            if (!Schema::hasColumn('subscription_plans', 'button_text')) {
                $table->string('button_text')->nullable()->after('features');
            }
            if (!Schema::hasColumn('subscription_plans', 'is_featured')) {
                $table->boolean('is_featured')->default(false)->after('button_text');
            }
            if (!Schema::hasColumn('subscription_plans', 'sort_order')) {
                $table->integer('sort_order')->default(0)->after('is_featured');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subscription_plans', function (Blueprint $table) {
            $table->dropColumn(['price_description', 'button_text', 'is_featured', 'sort_order']);
        });
    }
};
