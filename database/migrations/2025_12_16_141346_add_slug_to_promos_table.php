<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('promos', function (Blueprint $table) {
            // 1. Tambahkan kolom slug (sementara bisa null)
            $table->string('slug')->nullable()->after('name');
        });

        // 2. Isi kolom slug untuk data yang sudah ada
        DB::table('promos')->orderBy('id')->chunk(100, function ($promos) {
            foreach ($promos as $promo) {
                $slug = Str::slug($promo->name);
                $originalSlug = $slug;
                $counter = 1;

                // Pastikan slug unik
                while (DB::table('promos')->where('slug', $slug)->where('id', '!=', $promo->id)->exists()) {
                    $slug = $originalSlug . '-' . $counter;
                    $counter++;
                }

                DB::table('promos')->where('id', $promo->id)->update(['slug' => $slug]);
            }
        });

        // 3. Ubah kolom slug menjadi tidak boleh null dan tambahkan constraint unique
        Schema::table('promos', function (Blueprint $table) {
            $table->string('slug')->nullable(false)->change();
            $table->unique('slug');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('promos', function (Blueprint $table) {
            $table->dropUnique(['slug']);
            $table->dropColumn('slug');
        });
    }
};
