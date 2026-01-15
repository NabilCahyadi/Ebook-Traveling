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
        Schema::table('user_readings', function (Blueprint $table) {
            $table->integer('bookmark_page')->nullable()->after('last_page');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_readings', function (Blueprint $table) {
            $table->dropColumn('bookmark_page');
        });
    }
};
