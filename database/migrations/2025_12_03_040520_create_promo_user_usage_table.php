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
        Schema::create('promo_user_usage', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('promo_id');
            $table->uuid('user_id');
            $table->uuid('subscription_id')->nullable(); // relasi ke subscription yang dibuat
            $table->decimal('original_price', 10, 2);
            $table->decimal('final_price', 10, 2);
            $table->decimal('discount_amount', 10, 2);
            $table->timestamps();

            // Foreign keys
            $table->foreign('promo_id')->references('id')->on('promos')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('subscription_id')->references('id')->on('subscriptions')->onDelete('set null');

            // Indexes
            $table->index('promo_id');
            $table->index('user_id');
            $table->index(['promo_id', 'user_id']); // composite untuk cek usage per user
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promo_user_usage');
    }
};
