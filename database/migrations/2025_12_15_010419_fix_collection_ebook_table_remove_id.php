<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Remove id column and use composite primary key for pivot table
     */
    public function up(): void
    {
        // Check if id column exists before dropping
        if (Schema::hasColumn('collection_ebook', 'id')) {
            Schema::table('collection_ebook', function (Blueprint $table) {
                // Drop unique constraint first if exists
                try {
                    $table->dropUnique('collection_ebook_unique');
                } catch (\Exception $e) {
                    // Index might not exist, that's okay
                }

                // Drop primary key on id
                $table->dropPrimary(['id']);

                // Drop the id column
                $table->dropColumn('id');
            });

            // Add composite primary key in separate statement
            Schema::table('collection_ebook', function (Blueprint $table) {
                $table->primary(['collection_id', 'ebook_id']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('collection_ebook', function (Blueprint $table) {
            // Drop composite primary key
            $table->dropPrimary(['collection_id', 'ebook_id']);

            // Add back id column
            $table->uuid('id')->first();

            // Add back primary key on id
            $table->primary('id');

            // Add back unique constraint
            $table->unique(['collection_id', 'ebook_id'], 'collection_ebook_unique');
        });
    }
};
