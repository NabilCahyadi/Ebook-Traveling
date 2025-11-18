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
        Schema::create('help_guide_steps', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('help_guide_id');
            $table->string('sub_title'); // 'ebooks.gramedia.com', 'Android / iOS'
            $table->integer('steps_order')->default(0);
            $table->json('steps_content'); // Array of steps: ["Step 1...", "Step 2..."]
            $table->timestamps();

            $table->foreign('help_guide_id')->references('id')->on('help_guides')->onDelete('cascade');
            $table->index('help_guide_id');
            $table->index('steps_order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('help_guide_steps');
    }
};
