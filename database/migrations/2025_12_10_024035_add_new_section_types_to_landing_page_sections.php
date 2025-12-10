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
        Schema::table('landing_page_sections', function (Blueprint $table) {
            // Add section_data column for storing section content (JSON)
            $table->json('section_data')->nullable()->after('config');

            // Add section_title column for custom section titles
            if (!Schema::hasColumn('landing_page_sections', 'section_title')) {
                $table->string('section_title')->nullable()->after('section_name');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('landing_page_sections', function (Blueprint $table) {
            $table->dropColumn(['section_data', 'section_title']);
        });
    }
};
