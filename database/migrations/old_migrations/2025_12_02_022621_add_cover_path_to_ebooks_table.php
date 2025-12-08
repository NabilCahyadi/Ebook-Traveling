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
        Schema::table('ebooks', function (Blueprint $table) {
            // Add cover_path column for storing cropped cover image
            $table->string('cover_path', 500)->nullable()->after('cover_image');
            $table->index('cover_path');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ebooks', function (Blueprint $table) {
            $table->dropIndex(['cover_path']);
            $table->dropColumn('cover_path');
        });
    }
};
