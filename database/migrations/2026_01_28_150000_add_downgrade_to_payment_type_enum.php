<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // ✅ MySQL: Modify ENUM to add 'downgrade' value
        DB::statement("ALTER TABLE `payments` MODIFY COLUMN `payment_type` ENUM('new', 'renewal', 'upgrade', 'downgrade') DEFAULT 'new' COMMENT 'Type of payment: new subscription, renewal, upgrade, or downgrade'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // ✅ Revert back to original ENUM values
        DB::statement("ALTER TABLE `payments` MODIFY COLUMN `payment_type` ENUM('new', 'renewal', 'upgrade') DEFAULT 'new' COMMENT 'Type of payment: new subscription, renewal, or upgrade'");
    }
};
