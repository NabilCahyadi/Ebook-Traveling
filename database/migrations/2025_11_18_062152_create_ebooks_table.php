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
        Schema::create('ebooks', function (Blueprint $table) {
            // Primary Key
            $table->uuid('id')->primary();

            // Core Information
            $table->string('title', 500);
            $table->string('slug', 500)->unique();
            $table->text('description')->nullable();
            $table->text('short_description')->nullable(); // Ditambahkan sesuai seeder
            $table->string('author', 255)->nullable(); // Ditambahkan kembali sesuai seeder

            // Media & Files
            $table->string('cover_image', 500)->nullable();
            $table->string('pdf_file', 500)->nullable(); // Menggunakan 'pdf_file' sesuai seeder

            // Metadata
            $table->string('language', 10)->default('id');
            $table->string('status', 20)->default('draft'); // draft, published, archived, etc.
            $table->decimal('average_rating', 3, 2)->nullable(); // Ditambahkan kembali, contoh: 4.90
            $table->integer('total_reviews')->default(0);

            // Counts
            $table->integer('view_count')->default(0);
            $table->integer('read_count')->default(0);

            // Relations (Foreign Keys)
            $table->uuid('creator_id')->nullable();
            $table->uuid('category_id')->nullable(); // Saya tambahkan untuk desain yang baik
            $table->uuid('city_id')->nullable();    // Saya tambahkan untuk desain yang baik

            // Timestamps
            $table->timestamp('published_at')->nullable();
            $table->timestamps();

            // Definisi Foreign Keys
            $table->foreign('creator_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('set null');

            // Indexes untuk performa
            $table->index('slug');
            $table->index('status');
            $table->index('creator_id');
            $table->index('category_id');
            $table->index('city_id');
            $table->index('author');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ebooks');
    }
};
