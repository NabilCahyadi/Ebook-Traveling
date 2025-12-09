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
        Schema::create('landing_page_sections', function (Blueprint $table) {
            $table->id();
            $table->string('section_type'); // banner, top_cities, collection, subscription_plans, latest_blogs
            $table->string('section_name');
            $table->string('reference_id')->nullable(); // ID collection jika type = collection
            $table->integer('order')->default(0);
            $table->boolean('is_visible')->default(true);
            $table->json('config')->nullable(); // Untuk konfigurasi tambahan (limit items, dll)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('landing_page_sections');
    }
};
