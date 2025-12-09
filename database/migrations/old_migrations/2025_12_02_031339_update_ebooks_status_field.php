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
            // Update existing records with 'active' to 'published'
            \DB::table('ebooks')->where('status', 'active')->update(['status' => 'published']);
            // Update existing records with 'inactive' to 'unpublished'
            \DB::table('ebooks')->where('status', 'inactive')->update(['status' => 'unpublished']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ebooks', function (Blueprint $table) {
            // Revert back to original status values
            \DB::table('ebooks')->where('status', 'published')->update(['status' => 'active']);
            \DB::table('ebooks')->where('status', 'unpublished')->update(['status' => 'inactive']);
        });
    }
};
