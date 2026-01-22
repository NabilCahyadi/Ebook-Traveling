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
        Schema::table('blogs', function (Blueprint $table) {
            // Drop foreign key first
            $table->dropForeign(['author_id']);
            
            // Make author_id nullable
            $table->uuid('author_id')->nullable()->change();
            
            // Re-add foreign key
            $table->foreign('author_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('blogs', function (Blueprint $table) {
            // Drop foreign key
            $table->dropForeign(['author_id']);
            
            // Make author_id not nullable
            $table->uuid('author_id')->nullable(false)->change();
            
            // Re-add foreign key with cascade
            $table->foreign('author_id')->references('id')->on('users')->onDelete('cascade');
        });
    }
};
