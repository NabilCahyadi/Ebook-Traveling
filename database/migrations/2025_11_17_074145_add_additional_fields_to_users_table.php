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
        Schema::table('users', function (Blueprint $table) {
            $table->string('google_id')->nullable()->after('password');
            $table->string('phone')->nullable()->after('google_id');
            $table->string('avatar')->nullable()->after('phone');
            $table->string('status')->default('active')->after('avatar'); // active, inactive, suspended
            $table->foreignId('role_id')->nullable()->constrained('roles')->onDelete('set null')->after('status');
            $table->string('language_pref')->default('en')->after('role_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['role_id']);
            $table->dropColumn(['google_id', 'phone', 'avatar', 'status', 'role_id', 'language_pref']);
        });
    }
};
