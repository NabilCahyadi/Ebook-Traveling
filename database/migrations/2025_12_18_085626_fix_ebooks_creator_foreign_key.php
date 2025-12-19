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
            // Buat foreign key yang benar ke creators table
            $table->foreign('creator_id')
                  ->references('id')
                  ->on('creators')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ebooks', function (Blueprint $table) {
            // Drop foreign key baru
            $table->dropForeign(['creator_id']);
            
            // Kembalikan ke foreign key lama (ke users)
            $table->foreign('creator_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('set null');
        });
    }
};
