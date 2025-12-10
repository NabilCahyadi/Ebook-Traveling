<?php

namespace Database\Seeders;

use App\Models\SubscriptionPlan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class SubscriptionPlanSeeder extends Seeder
{
    public function run(): void
    {
        $plans = [
            [
                'id' => Str::uuid(),
                'name' => 'Free Plan',
                'slug' => 'free-plan',
                'description' => 'Akses terbatas ke beberapa e-book gratis.',
                'cover_image' => 'banner-subs-1.webp', // Cover Image ditambahkan
                'price' => 0.00,
                'duration_days' => 0, // 0 berarti tidak ada batas waktu
                'features' => json_encode([
                    'Akses 5 e-book gratis per bulan',
                    'Iklan akan ditampilkan',
                    'Dukungan standar'
                ]),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Monthly Explorer',
                'slug' => 'monthly-explorer',
                'description' => 'Akses tidak terbatas ke semua e-book selama sebulan.',
                'cover_image' => 'banner-subs-2.webp', // Cover Image ditambahkan
                'price' => 49000.00,
                'duration_days' => 30,
                'features' => json_encode([
                    'Akses tidak terbatas ke semua e-book',
                    'Unduh 10 e-book per bulan',
                    'Tanpa iklan',
                    'Dukungan prioritas'
                ]),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Yearly Voyager',
                'slug' => 'yearly-voyager',
                'description' => 'Akses tidak terbatas sepanjang tahun dengan harga terbaik.',
                'cover_image' => 'banner-subs-3.webp', // Cover Image ditambahkan
                'price' => 499000.00,
                'duration_days' => 365,
                'features' => json_encode([
                    'Akses tidak terbatas ke semua e-book',
                    'Unduh tidak terbatas',
                    'Tanpa iklan',
                    'Akses konten eksklusif',
                    'Dukungan prioritas 24/7'
                ]),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('subscription_plans')->insert($plans);

        $this->command->info('Subscription Plans created successfully!');
    }
}
