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
        Schema::create('promo_conditions', function (Blueprint $table) {
            $table->id();
            $table->uuid('promo_id');
            $table->string('condition_type', 50); // new_user, first_subscription, subscription_type, min_price
            $table->string('condition_value')->nullable(); // value for the condition
            $table->timestamps();

            $table->foreign('promo_id')->references('id')->on('promos')->onDelete('cascade');
            $table->index('promo_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promo_conditions');
    }
};
