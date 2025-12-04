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
        // Step 1: Add status column
        Schema::table('blogs', function (Blueprint $table) {
            $table->string('status', 20)->default('draft')->after('content');
        });

        // Step 2: Update existing data
        \DB::statement("UPDATE blogs SET status = CASE WHEN is_published = 1 THEN 'published' ELSE 'draft' END");

        // Step 3: Drop old column
        Schema::table('blogs', function (Blueprint $table) {
            $table->dropColumn('is_published');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Step 1: Add back is_published column
        Schema::table('blogs', function (Blueprint $table) {
            $table->boolean('is_published')->default(false)->after('content');
        });

        // Step 2: Restore data
        \DB::statement("UPDATE blogs SET is_published = CASE WHEN status = 'published' THEN 1 ELSE 0 END");

        // Step 3: Drop status column
        Schema::table('blogs', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
