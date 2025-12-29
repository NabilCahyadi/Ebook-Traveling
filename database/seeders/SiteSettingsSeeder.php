<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\SiteSetting;

class SiteSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('site_settings')->delete();

        $settings = [
            // site_settings = buat nyimpen informasi informasi di website (kaya kecil kecilan gitu, asal syaratnya ada key)
            [
                'key'   => 'address',
                'value' => 'Perumahan Jati Indah, Jl. Otista No.57 Blok. B, Panyingkiran, Kab. Ciamis, Jawa Barat',
                'type'  => 'text',
            ],
            [
                'key'   => 'phone',
                'value' => '628112345678',
                'type'  => 'phone',
            ],
            [
                'key'   => 'email',
                'value' => 'smactactic@gmail.com',
                'type'  => 'email',
            ],
            [
                'key'   => 'hours',
                'value' => '08:00 - 16:30, EveryDay',
                'type'  => 'text',
            ],
            // Informasi Umum
            [
                'key'   => 'tagline',
                'value' => 'The Most Comprehensive Indonesia Destination Guide',
                'type'  => 'text',
            ],
            [
                'key'   => 'short_tagline',
                'value' => 'Vacation Guide E-Book',
                'type'  => 'text',
            ],
            [
                'key'   => 'whatsapp_number',
                'value' => '6289657571177', // Nomor WhatsApp admin (WAJIB PAKE 62, JANGAN +62, JANGAN 08)
                'type'  => 'phone',
            ],
            [
                'key'   => 'admin_email',
                'value' => 'admin@meatmap.id', // Email admin
                'type'  => 'email',
            ],
        ];

        SiteSetting::insert($settings);
    }
}
