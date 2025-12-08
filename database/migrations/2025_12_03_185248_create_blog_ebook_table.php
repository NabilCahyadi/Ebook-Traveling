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
        Schema::create('blog_ebook', function (Blueprint $table) {
            // Gunakan char(36) jika ID blog Anda adalah UUID
            $table->char('blog_id', 36);
            $table->char('ebook_id', 36);

            // Tambahkan foreign key constraint
            $table->foreign('blog_id')->references('id')->on('blogs')->onDelete('cascade');
            $table->foreign('ebook_id')->references('id')->on('ebooks')->onDelete('cascade');

            // Jadikan kombinasi blog_id dan ebook_id sebagai primary key
            $table->primary(['blog_id', 'ebook_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blog_ebook');
    }
};
