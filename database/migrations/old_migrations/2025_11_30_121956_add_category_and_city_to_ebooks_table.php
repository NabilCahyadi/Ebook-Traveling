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
            $table->uuid('category_id')->nullable()->after('id');
            $table->uuid('city_id')->nullable()->after('category_id');

            $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ebooks', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropForeign(['city_id']);
            $table->dropColumn(['category_id', 'city_id']);
        });
    }
};
