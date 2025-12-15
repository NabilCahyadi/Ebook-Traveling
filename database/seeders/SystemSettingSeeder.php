<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SystemSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            [
                'id' => Str::uuid(), // Generate UUID untuk id
                'key' => 'default_cta_background_path',
                'value' => '/images/bg-default.webp', // Ganti dengan path gambar Anda
                'description' => 'Background untuk section Call-to-Action (CTA) default.',
            ],
            // Anda bisa menambahkan setting global lain di sini
        ];

        DB::table('system_settings')->insert($settings);
    }
}
