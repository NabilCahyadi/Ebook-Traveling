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
        Schema::create('page_sections', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('page_type'); // help, privacy, terms, shopping, payment
            $table->string('section_title')->nullable();      // "1. How to Register..."
            $table->string('subsection_title')->nullable();   // "1.1. Via Website"
            $table->text('content'); // teks biasa (bukan HTML)
            $table->integer('order_index')->default(0);
            $table->timestamps();

            $table->index('page_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('page_sections');
    }
};
