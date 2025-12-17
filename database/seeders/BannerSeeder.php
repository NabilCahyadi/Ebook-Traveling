<?php

namespace Database\Seeders;

use App\Models\Banner;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BannerSeeder extends Seeder
{
    public function run(): void
    {
        // Clear existing banners
        Banner::truncate();

        Banner::insert([
            [
                'id' => Str::uuid(),
                'title' => 'Explore Indonesia Travel Guides',
                'description' => 'Jelajahi panduan wisata lengkap untuk destinasi terbaik di Indonesia. Dapatkan akses unlimited ke ribuan ebook travel.',
                'image' => 'slider-1.webp',
                'type' => 'hero',
                'target_url' => null,
                'is_active' => true,
                'start_date' => null,
                'end_date' => null,
                'order_index' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'title' => 'Subscribe & Access All Travel Ebooks',
                'description' => 'Berlangganan sekarang dan nikmati akses tak terbatas ke semua ebook panduan wisata. Seperti Netflix, tapi untuk traveler!',
                'image' => 'slider-2.webp',
                'type' => 'hero',
                'target_url' => '/pricing',
                'is_active' => true,
                'start_date' => null,
                'end_date' => null,
                'order_index' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'title' => 'Discover Hidden Gems',
                'description' => 'Temukan destinasi tersembunyi dan tempat-tempat eksotis yang jarang dikunjungi. Panduan lengkap dari para traveler berpengalaman.',
                'image' => 'banner-vertikal.webp',
                'type' => 'hero',
                'target_url' => '/destinations',
                'is_active' => true,
                'start_date' => null,
                'end_date' => null,
                'order_index' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        $this->command->info('Successfully seeded ' . Banner::count() . ' banners.');
    }
}
