<?php

namespace Database\Seeders;

use App\Models\Banner;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BannerSeeder extends Seeder
{
    public function run(): void
    {
        Banner::insert([
            [
                'id' => Str::uuid(),
                'title' => 'Get My Essential Travel Guide',
                'description' => 'Access insider tips and verified travel itineraries.',
                'image' => 'images/slider-1.webp',
                'type' => 'home_slider',
                'target_url' => '/pricing',
                'is_active' => true,
                'start_date' => now(),
                'end_date' => now()->addMonths(3),
                'order_index' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'title' => 'Start Your Plan Claim Your Promo',
                'description' => 'Save up to 50% off on your first order',
                'image' => 'images/slider-2.webp',
                'type' => 'home_slider',
                'target_url' => '/promo',
                'is_active' => true,
                'start_date' => now(),
                'end_date' => now()->addMonths(2),
                'order_index' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
