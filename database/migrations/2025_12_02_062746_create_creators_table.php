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
        Schema::create('creators', function (Blueprint $table) {
            $table->uuid('id')->primary(); // Menggunakan UUID untuk konsistensi
            $table->foreignUuid('user_id')->constrained('users')->onDelete('cascade'); // Hubungkan ke tabel users
            $table->string('pen_name', 255)->nullable(); // Nama pena, jika berbeda dari nama user
            $table->text('bio')->nullable(); // Biografi singkat creator
            $table->string('avatar', 500)->nullable(); // URL foto profil creator
            $table->json('social_media_links')->nullable(); // Link ke media sosial (misal: {"twitter": "...", "instagram": "..."})
            $table->boolean('is_active')->default(true); // Status aktif creator
            $table->timestamps();

            $table->unique('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('creators');
    }
};
