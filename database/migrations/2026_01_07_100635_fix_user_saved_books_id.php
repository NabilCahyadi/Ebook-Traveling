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
        Schema::table('user_saved_books', function (Blueprint $table) {
            // Hapus kolom id yang manual
            $table->dropPrimary('id');
            $table->dropColumn('id');

            // Tambahkan id auto-increment
            $table->id()->first(); // Jadi primary key baru
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_saved_books', function (Blueprint $table) {
            $table->dropColumn('id');
            $table->char('id', 36)->primary()->first();
        });
    }
};
