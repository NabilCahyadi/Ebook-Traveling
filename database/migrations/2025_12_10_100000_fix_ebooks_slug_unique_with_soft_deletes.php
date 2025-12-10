<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Masalah: Unique constraint pada slug tidak memperhitungkan soft deletes
     * Solusi: Drop unique constraint dan andalkan validasi di kode aplikasi (Model::generateUniqueSlug)
     */
    public function up(): void
    {
        // Cek apakah unique constraint ada sebelum di-drop
        $indexes = DB::select("SHOW INDEXES FROM ebooks WHERE Key_name = 'ebooks_slug_unique'");
        
        if (!empty($indexes)) {
            Schema::table('ebooks', function (Blueprint $table) {
                $table->dropUnique('ebooks_slug_unique');
            });
        }
        
        // Pastikan index biasa ada untuk performa query
        $slugIndex = DB::select("SHOW INDEXES FROM ebooks WHERE Key_name = 'ebooks_slug_index'");
        
        if (empty($slugIndex)) {
            Schema::table('ebooks', function (Blueprint $table) {
                $table->index('slug', 'ebooks_slug_index');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ebooks', function (Blueprint $table) {
            // Kembalikan ke unique constraint
            $table->unique('slug');
        });
    }
};
