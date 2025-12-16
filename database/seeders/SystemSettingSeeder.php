<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SystemSettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            [
                'key' => 'default_cta_background_path',
                'value' => '/images/bg-default.webp',
                'description' => 'Background untuk section Call-to-Action (CTA) default.',
            ],
        ];

        foreach ($settings as $setting) {
            DB::table('system_settings')->updateOrInsert(
                ['key' => $setting['key']], // kondisi pencarian
                [
                    'id' => Str::uuid(),
                    'value' => $setting['value'],
                    'description' => $setting['description'],
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
        }
    }
}
