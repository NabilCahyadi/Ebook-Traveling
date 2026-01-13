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
        Schema::create('admin_permission', function (Blueprint $table) {
            $table->uuid('admin_id');
            $table->uuid('admin_permission_id');
            $table->timestamps();

            // Foreign keys
            $table->foreign('admin_id')->references('id')->on('admins')->onDelete('cascade');
            $table->foreign('admin_permission_id')->references('id')->on('admin_permissions')->onDelete('cascade');

            // Composite primary key
            $table->primary(['admin_id', 'admin_permission_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_permission');
    }
};
