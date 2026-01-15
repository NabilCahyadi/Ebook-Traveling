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
            // Change user_type column to only distinguish subscription status
            // Drop index first
            $table->dropIndex(['user_type']);
            
            // Modify column
            $table->string('user_type', 20)->default('free_user')->change(); // free_user, member
            
            // Add index back
            $table->index('user_type');
        });
        
        // Update existing data: convert old user_type to new system
        // member/creator/admin users -> member (paid subscription)
        // Keep 'free_user' as is
        DB::statement("UPDATE users SET user_type = 'member' WHERE user_type IN ('member', 'creator', 'admin')");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['user_type']);
            $table->string('user_type', 20)->default('member')->change(); // member, creator, admin
            $table->index('user_type');
        });
    }
};
