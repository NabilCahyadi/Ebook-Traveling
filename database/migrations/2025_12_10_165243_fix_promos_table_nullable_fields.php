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
        Schema::table('promos', function (Blueprint $table) {
            // Make old fields nullable for backward compatibility
            $table->string('discount_type', 20)->nullable()->change();
            $table->decimal('discount_value', 10, 2)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('promos', function (Blueprint $table) {
            // Revert back to NOT NULL
            $table->string('discount_type', 20)->nullable(false)->change();
            $table->decimal('discount_value', 10, 2)->nullable(false)->change();
        });
    }
};
