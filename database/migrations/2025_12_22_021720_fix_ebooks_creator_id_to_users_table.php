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
            // Drop existing foreign key jika ada
            try {
                $table->dropForeign(['creator_id']);
            } catch (\Exception $e) {
                // Ignore jika tidak ada
            }
        });

        Schema::table('ebooks', function (Blueprint $table) {
            // Tambah foreign key ke users
            $table->foreign('creator_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ebooks', function (Blueprint $table) {
            // Drop foreign key saat rollback
            $table->dropForeign(['creator_id']);
        });
    }
};
