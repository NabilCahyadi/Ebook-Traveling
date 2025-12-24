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
        Schema::table('action_logs', function (Blueprint $table) {
            $table->uuid('admin_id')->nullable()->after('user_id');
            $table->string('user_type', 20)->default('user')->after('admin_id')->comment('user or admin');
            
            $table->foreign('admin_id')->references('id')->on('admins')->onDelete('set null');
            $table->index('admin_id');
            $table->index('user_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('action_logs', function (Blueprint $table) {
            $table->dropForeign(['admin_id']);
            $table->dropIndex(['admin_id']);
            $table->dropIndex(['user_type']);
            $table->dropColumn(['admin_id', 'user_type']);
        });
    }
};
