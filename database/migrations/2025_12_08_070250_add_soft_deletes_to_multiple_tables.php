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
        // Add soft deletes to blogs table
        Schema::table('blogs', function (Blueprint $table) {
            $table->softDeletes();
        });

        // Add soft deletes to categories table
        Schema::table('categories', function (Blueprint $table) {
            $table->softDeletes();
        });

        // Add soft deletes to banners table
        Schema::table('banners', function (Blueprint $table) {
            $table->softDeletes();
        });

        // Add soft deletes to ebooks table
        Schema::table('ebooks', function (Blueprint $table) {
            $table->softDeletes();
        });

        // Add soft deletes to roles table
        Schema::table('roles', function (Blueprint $table) {
            $table->softDeletes();
        });

        // Add soft deletes to subscription_plans table
        Schema::table('subscription_plans', function (Blueprint $table) {
            $table->softDeletes();
        });

        // Add soft deletes to faqs table (if exists)
        if (Schema::hasTable('faqs')) {
            Schema::table('faqs', function (Blueprint $table) {
                $table->softDeletes();
            });
        }

        // Add soft deletes to promos table (if exists)
        if (Schema::hasTable('promos')) {
            Schema::table('promos', function (Blueprint $table) {
                $table->softDeletes();
            });
        }

        // Add soft deletes to help_guides table (if exists)
        if (Schema::hasTable('help_guides')) {
            Schema::table('help_guides', function (Blueprint $table) {
                $table->softDeletes();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('banners', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('ebooks', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('roles', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('subscription_plans', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        if (Schema::hasTable('faqs')) {
            Schema::table('faqs', function (Blueprint $table) {
                $table->dropSoftDeletes();
            });
        }

        if (Schema::hasTable('promos')) {
            Schema::table('promos', function (Blueprint $table) {
                $table->dropSoftDeletes();
            });
        }

        if (Schema::hasTable('help_guides')) {
            Schema::table('help_guides', function (Blueprint $table) {
                $table->dropSoftDeletes();
            });
        }
    }
};
