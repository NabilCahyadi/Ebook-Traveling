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
            $table->uuid('category_id')->nullable();
            $table->uuid('city_id')->nullable();
            $table->string('title', 500);
            $table->string('slug', 500)->unique();
            $table->text('description')->nullable();
            $table->string('cover_image', 500)->nullable();
            $table->string('file_url', 500)->nullable();
            $table->integer('page_count')->default(0);
            $table->string('status', 20)->default('draft'); // draft, published, archived, waiting_approval
            $table->integer('view_count')->default(0);
            $table->integer('read_count')->default(0);
            $table->integer('total_reviews')->default(0);
            $table->uuid('creator_id')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->timestamps();

            // Foreign keys
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('set null');
            $table->foreign('creator_id')->references('id')->on('users')->onDelete('set null');

            // Indexes
            $table->index('slug');
            $table->index('status');
            $table->index('category_id');
            $table->index('city_id');
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
