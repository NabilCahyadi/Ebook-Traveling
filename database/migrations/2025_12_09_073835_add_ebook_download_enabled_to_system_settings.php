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
        // Insert default setting for ebook download
        DB::table('system_settings')->updateOrInsert(
            ['key' => 'ebook_download_enabled'],
            [
                'id' => \Illuminate\Support\Str::uuid(),
                'value' => '1', // 1 = enabled, 0 = disabled
                'description' => 'Enable or disable ebook downloads globally for all users',
                'created_at' => now(),
                'updated_at' => now()
            ]
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('system_settings')->where('key', 'ebook_download_enabled')->delete();
    }
};
