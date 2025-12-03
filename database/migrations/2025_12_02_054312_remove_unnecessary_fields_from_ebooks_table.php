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
            // Hapus field yang tidak relevan dengan model berlangganan
            $table->dropColumn([
                'price',
                'discount_price',
                'sales_count',
                'is_free',
            ]);

            // Hapus field yang kurang penting untuk menyederhanakan tabel
            $table->dropColumn([
                'publisher',
                'isbn',
                'page_count',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ebooks', function (Blueprint $table) {
            $table->decimal('price', 10, 2)->default(0.00);
            $table->decimal('discount_price', 10, 2)->nullable();
            $table->integer('sales_count')->default(0);
            $table->tinyInteger('is_free')->default(0);
            $table->string('publisher', 255)->nullable();
            $table->string('isbn', 50)->nullable();
            $table->integer('page_count')->default(0);
        });
    }
};
