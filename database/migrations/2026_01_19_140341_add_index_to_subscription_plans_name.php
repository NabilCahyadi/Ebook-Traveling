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
        Schema::table('subscription_plans_name', function (Blueprint $table) {
            Schema::table('subscription_plans', function (Blueprint $table) {
                $table->index('name');
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subscription_plans_name', function (Blueprint $table) {
            Schema::table('subscription_plans', function (Blueprint $table) {
                $table->dropIndex(['name']);
            });
        });
    }
};
