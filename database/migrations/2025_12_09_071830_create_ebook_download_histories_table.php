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
        Schema::create('ebook_download_histories', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('ebook_id'); // Foreign key to ebooks
            $table->boolean('is_downloadable')->default(false); // Status download ON/OFF
            $table->string('changed_by')->nullable(); // User ID yang mengubah (admin)
            $table->text('notes')->nullable(); // Catatan kenapa diubah
            $table->timestamps();

            // Foreign keys
            $table->foreign('ebook_id')->references('id')->on('ebooks')->onDelete('cascade');
            $table->foreign('changed_by')->references('id')->on('users')->onDelete('set null');

            // Index untuk performa
            $table->index(['ebook_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ebook_download_histories');
    }
};
