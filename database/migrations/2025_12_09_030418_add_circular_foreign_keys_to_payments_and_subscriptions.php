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
        // Add foreign key dari payments ke orders
        Schema::table('payments', function (Blueprint $table) {
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
        });

        // Add foreign key dari subscriptions ke payments
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->foreign('payment_id')->references('id')->on('payments')->onDelete('set null');
        });

        // Add foreign key dari payments ke subscriptions
        Schema::table('payments', function (Blueprint $table) {
            $table->foreign('subscription_id')->references('id')->on('subscriptions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropForeign(['order_id']);
            $table->dropForeign(['subscription_id']);
        });

        Schema::table('subscriptions', function (Blueprint $table) {
            $table->dropForeign(['payment_id']);
        });
    }
};
