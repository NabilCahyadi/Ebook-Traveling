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
        Schema::create('collection_ebooks', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('collection_id');
            $table->uuid('ebook_id');
            $table->integer('order_index')->default(0);
            $table->timestamps();

            // Foreign keys
            $table->foreign('collection_id')
                ->references('id')
                ->on('collections')
                ->onDelete('cascade');

            $table->foreign('ebook_id')
                ->references('id')
                ->on('ebooks')
                ->onDelete('cascade');

            // Indexes
            $table->index('collection_id');
            $table->index('ebook_id');
            $table->unique(['collection_id', 'ebook_id'], 'collection_ebook_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('collection_ebooks');
    }
};
