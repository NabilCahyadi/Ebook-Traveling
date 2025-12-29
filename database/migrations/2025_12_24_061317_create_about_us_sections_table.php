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
        Schema::create('about_us_sections', function (Blueprint $table) {
            $table->id();
            $table->string('section_key')->unique(); // Kunci unik: 'welcome', 'performance', dll.
            $table->string('title');
            $table->text('content'); // Untuk konten yang mendukung HTML
            $table->string('image')->nullable(); // Gambar opsional
            $table->string('layout_type')->default('default'); // 'default', 'image_left', 'three_cols'
            $table->unsignedInteger('order_index')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('about_us_sections');
    }
};
