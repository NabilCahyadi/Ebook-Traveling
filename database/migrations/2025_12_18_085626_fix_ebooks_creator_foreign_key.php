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
        // Pertama, kita harus menghapus foreign key LAMA yang mungkin ada
        // untuk menghindari error "Duplicate foreign key constraint".
        // Nama constraint biasanya mengikuti format 'tabel_kolom_foreign'.
        Schema::table('ebooks', function (Blueprint $table) {
            $table->dropForeign(['creator_id']);
        });

        // Setelah foreign key lama dihapus, sekarang kita bisa membuat yang BARU
        // yang mengarah ke tabel 'creators'.
        Schema::table('ebooks', function (Blueprint $table) {
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
        // Untuk membalikkan, kita harus menghapus foreign key BARU yang kita buat
        Schema::table('ebooks', function (Blueprint $table) {
            $table->dropForeign(['creator_id']);
        });

        // Lalu, kita kembalikan foreign key LAMA (yang mengarah ke tabel 'users')
        Schema::table('ebooks', function (Blueprint $table) {
            $table->foreign('creator_id')
                ->references('id')
                ->on('users')
                ->onDelete('set null');
        });
    }
};
