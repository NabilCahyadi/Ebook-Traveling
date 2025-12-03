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
        Schema::table('cities', function (Blueprint $table) {
            $table->string('slug')->unique()->after('name');
            $table->text('description')->nullable()->after('slug');
            $table->string('image')->nullable()->after('description');
            // BARIS DI BAWAH INI YANG TELAH DIPERBAIKI
            $table->string('province')->nullable()->after('image');
            $table->integer('order_index')->default(0)->after('province');
            $table->boolean('is_active')->default(true)->after('order_index');
            $table->boolean('is_popular')->default(false)->after('is_active');
            $table->integer('views_count')->default(0)->after('is_popular');

            // Tambah indexes
            $table->index('slug');
            $table->index('is_active');
            $table->index('is_popular');
            $table->index('order_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cities', function (Blueprint $table) {
            $table->dropColumn([
                'slug',
                'description',
                'image',
                'province',
                'order_index',
                'is_active',
                'is_popular',
                'views_count'
            ]);

            // Hapus indexes
            $table->dropIndex(['slug']);
            $table->dropIndex(['is_active']);
            $table->dropIndex(['is_popular']);
            $table->dropIndex(['order_index']);
        });
    }
};
