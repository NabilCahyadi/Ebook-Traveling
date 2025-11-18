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
            $table->uuid('id')->primary();
            $table->string('title', 500);
            $table->string('slug', 500)->unique();
            $table->text('description')->nullable();
            $table->string('short_description', 1000)->nullable();
            $table->string('author');
            $table->string('publisher')->nullable();
            $table->string('isbn', 50)->nullable();
            $table->string('cover_image', 500)->nullable();
            $table->text('content_text')->nullable(); // Optional: for text-based content
            $table->string('pdf_file', 500)->nullable(); // PDF file path
            $table->integer('page_count')->default(0);
            $table->string('language', 10)->default('id');
            $table->decimal('price', 10, 2)->default(0);
            $table->decimal('discount_price', 10, 2)->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_free')->default(false);
            $table->string('status', 20)->default('draft'); // draft, published, archived
            $table->integer('view_count')->default(0);
            $table->integer('read_count')->default(0);
            $table->decimal('average_rating', 3, 2)->default(0.00);
            $table->integer('total_reviews')->default(0);
            $table->uuid('creator_id')->nullable(); // User yang membuat ebook (jika creator)
            $table->timestamp('published_at')->nullable();
            $table->timestamps();

            $table->foreign('creator_id')->references('id')->on('users')->onDelete('set null');
            $table->index('slug');
            $table->index('status');
            $table->index('is_featured');
            $table->index('author');
            $table->index('creator_id');
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
