<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PricingBanner;

class PricingBannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Menggunakan Model untuk membuat data
        // Ini akan otomatis menggunakan kolom-kolom yang ada di $fillable
        PricingBanner::create([
            'judul_utama' => 'Access Every Guide<br />Unlock Limitless Adventure.',
            'deskripsi' => 'Get instant, ad-free access to our entire library of verified city guides and premium travel itineraries.',
            'gambar_banner' => '/images/banner-pricing.webp',
            'status' => 'active', // Secara eksplisit menetapkan status sebagai aktif
        ]);
    }
}
