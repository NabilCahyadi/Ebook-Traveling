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
        Schema::create('contact_infos', function (Blueprint $table) {
            $table->id();
            $table->string('contact_type')->unique(); // 'whatsapp', 'email', 'phone'
            $table->string('title'); // 'Instagram Support', 'Email Support', 'Phone Support'
            $table->text('description'); // 'Available Monday - Friday...'
            $table->string('link'); // 'https://wa.me/...', 'mailto:...', 'tel:...'
            $table->string('icon_class'); // 'bi bi-whatsapp', 'bi bi-envelope', 'bi bi-telephone'
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_infos');
    }
};
