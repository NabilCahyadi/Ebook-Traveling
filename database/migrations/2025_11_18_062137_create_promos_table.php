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
        Schema::create('promos', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('code')->unique()->nullable();
            $table->text('description')->nullable();
            $table->enum('type', ['percentage', 'fixed_amount', 'free_trial'])->nullable();
            $table->decimal('value', 10, 2)->nullable();
            $table->integer('max_usage')->nullable();
            $table->integer('max_usage_per_user')->default(1);
            $table->integer('current_usage')->default(0);
            $table->string('banner_image', 500)->nullable();
            $table->string('discount_type', 20); // percentage, fixed
            $table->decimal('discount_value', 10, 2);
            $table->decimal('min_purchase_amount', 10, 2)->default(0);
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();
            $table->text('terms_conditions')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('is_active');
            $table->index('start_date');
            $table->index('end_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promos');
    }
};
