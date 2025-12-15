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
        Schema::create('pricing_benefits', function (Blueprint $table) {
            $table->id();
            $table->string('icon'); // untuk menyimpan class icon, misal: 'bi bi-globe-americas'
            $table->string('title'); // judul benefit
            $table->text('description'); // deskripsi benefit
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->integer('sort_order')->default(0); // untuk mengurutkan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pricing_benefits');
    }
};
