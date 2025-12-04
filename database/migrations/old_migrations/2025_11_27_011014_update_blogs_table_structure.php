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
        Schema::table('blogs', function (Blueprint $table) {
            // Drop foreign key and category_id column
            $table->dropForeign(['category_id']);
            $table->dropColumn('category_id');
            
            // Add category as string and tags as JSON
            $table->string('category', 100)->nullable()->after('author_id');
            $table->json('tags')->nullable()->after('category');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('blogs', function (Blueprint $table) {
            // Remove new columns
            $table->dropColumn(['category', 'tags']);
            
            // Restore category_id
            $table->uuid('category_id')->nullable()->after('author_id');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');
        });
    }
};
