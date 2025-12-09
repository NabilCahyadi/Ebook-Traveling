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
            // Drop tags column if exists
            if (Schema::hasColumn('blogs', 'tags')) {
                $table->dropColumn('tags');
            }
        });

        // Add blog_category_id if not exists
        if (!Schema::hasColumn('blogs', 'blog_category_id')) {
            Schema::table('blogs', function (Blueprint $table) {
                $table->uuid('blog_category_id')->nullable()->after('author_id');
                $table->foreign('blog_category_id')->references('id')->on('blog_categories')->onDelete('set null');
                $table->index('blog_category_id');
            });
        } else {
            // If column exists but foreign key might not, try to add it
            try {
                Schema::table('blogs', function (Blueprint $table) {
                    $table->foreign('blog_category_id')->references('id')->on('blog_categories')->onDelete('set null');
                });
            } catch (\Exception $e) {
                // Foreign key already exists, ignore
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->dropForeign(['blog_category_id']);
            $table->dropColumn('blog_category_id');
            $table->json('tags')->nullable();
        });
    }
};
