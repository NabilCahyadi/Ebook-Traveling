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
        Schema::create('ebook_images', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('ebook_id');
            $table->string('image_url', 500);
            $table->integer('order_index')->default(0);
            $table->boolean('is_primary')->default(false);
            $table->timestamp('created_at')->nullable();

            $table->foreign('ebook_id')->references('id')->on('ebooks')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ebook_images');
    }
};
