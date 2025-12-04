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
        Schema::table('promos', function (Blueprint $table) {
            // Add code column for promo codes
            if (!Schema::hasColumn('promos', 'code')) {
                $table->string('code')->unique()->nullable()->after('name');
            }

            // Rename old columns if they exist
            if (!Schema::hasColumn('promos', 'type')) {
                $table->enum('type', ['percentage', 'fixed_amount', 'free_trial'])->nullable()->after('description');
            }

            if (!Schema::hasColumn('promos', 'value')) {
                $table->decimal('value', 10, 2)->nullable()->after('type');
            }

            // Add max_usage if not exists (for ebook promo it was usage_limit)
            if (!Schema::hasColumn('promos', 'max_usage')) {
                $table->integer('max_usage')->nullable()->after('value');
            }

            if (!Schema::hasColumn('promos', 'max_usage_per_user')) {
                $table->integer('max_usage_per_user')->default(1)->after('max_usage');
            }

            if (!Schema::hasColumn('promos', 'current_usage')) {
                $table->integer('current_usage')->default(0)->after('max_usage_per_user');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('promos', function (Blueprint $table) {
            $columns = ['code', 'type', 'value', 'max_usage', 'max_usage_per_user', 'current_usage'];
            foreach ($columns as $column) {
                if (Schema::hasColumn('promos', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
