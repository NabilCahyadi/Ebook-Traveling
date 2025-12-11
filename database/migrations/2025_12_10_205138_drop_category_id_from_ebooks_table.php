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
            // LANGKAH 1: Lepaskan gemboknya dulu (foreign key constraint)
            $table->dropForeign(['category_id']); // Laravel akan otomatis mencari nama constraint

            // LANGKAH 2: Baru kemudian hapus pintunya (kolomnya)
            $table->dropColumn('category_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ebooks', function (Blueprint $table) {
            // LANGKAH 1: Tambahkan kembali pintunya (kolomnya)
            $table->foreignUuid('category_id')->nullable();

            // LANGKAH 2: Baru kemudian pasang gemboknya (foreign key constraint)
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');
        });
    }
};
