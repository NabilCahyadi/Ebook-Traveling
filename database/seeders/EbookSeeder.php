<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ebook;
use App\Models\Category;
use App\Models\City;
use App\Models\User;
use Illuminate\Support\Str;

class EbookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get categories and cities
        $categories = Category::all();
        $cities = City::where('is_popular', true)->get();

        if ($cities->isEmpty()) {
            $cities = City::take(10)->get();
        }

        if ($categories->isEmpty()) {
            $this->command->error('No categories found. Please run CategorySeeder first.');
            return;
        }

        if ($cities->isEmpty()) {
            $this->command->error('No cities found. Please run CitySeeder first.');
            return;
        }

        // Get admin/creator user
        $admin = User::where('email', 'admin@ebook.com')
            ->orWhere('email', 'nabilcahyadi155@gmail.com')
            ->first();

        if (!$admin) {
            $admin = User::first();
        }

        $creatorId = $admin ? $admin->id : null;

        // Create 10 sample ebooks distributed across different cities
        $ebooks = [
            [
                'category_id' => $categories->random()->id,
                'city_id' => $cities->where('name', 'Denpasar')->first()?->id ?? $cities->random()->id,
                'title' => 'Complete Guide to Bali - Explore the Island of Gods',
                'slug' => 'complete-guide-to-bali-' . Str::random(5),
                'description' => 'Discover the most beautiful places in Bali, from stunning temples to pristine beaches. This comprehensive guide covers everything you need to know about Bali including best places to visit, local cuisine, accommodation tips, and cultural insights.',
                'page_count' => 150,
                'status' => 'published',
                'view_count' => rand(100, 500),
                'read_count' => rand(50, 200),
                'creator_id' => $creatorId,
                'published_at' => now()->subDays(30),
            ],
            [
                'category_id' => $categories->random()->id,
                'city_id' => $cities->where('name', 'Yogyakarta')->first()?->id ?? $cities->random()->id,
                'title' => 'Yogyakarta Cultural Heritage - History & Traditions',
                'slug' => 'yogyakarta-cultural-heritage-' . Str::random(5),
                'description' => 'Explore the rich cultural heritage of Yogyakarta, including Borobudur Temple, Prambanan, and traditional Javanese arts. Learn about the royal palace, batik making, and local traditions that make Yogyakarta unique.',
                'page_count' => 200,
                'status' => 'published',
                'view_count' => rand(100, 500),
                'read_count' => rand(50, 200),
                'creator_id' => $creatorId,
                'published_at' => now()->subDays(25),
            ],
            [
                'category_id' => $categories->random()->id,
                'city_id' => $cities->where('name', 'Jakarta')->first()?->id ?? $cities->random()->id,
                'title' => 'Jakarta Street Food Adventure - Culinary Journey',
                'slug' => 'jakarta-street-food-adventure-' . Str::random(5),
                'description' => 'A complete guide to Jakarta\'s amazing street food scene, from traditional dishes to modern fusion cuisine. Discover hidden food stalls, popular restaurants, and must-try dishes in the capital city.',
                'page_count' => 120,
                'status' => 'published',
                'view_count' => rand(100, 500),
                'read_count' => rand(50, 200),
                'creator_id' => $creatorId,
                'published_at' => now()->subDays(20),
            ],
            [
                'category_id' => $categories->random()->id,
                'city_id' => $cities->where('name', 'Mataram')->first()?->id ?? $cities->random()->id,
                'title' => 'Lombok Island Paradise - Beaches & Waterfalls',
                'slug' => 'lombok-island-paradise-' . Str::random(5),
                'description' => 'Discover Lombok\'s hidden gems, from stunning beaches to majestic waterfalls and Mount Rinjani. A complete guide for travelers seeking pristine nature and adventure activities.',
                'page_count' => 180,
                'status' => 'published',
                'view_count' => rand(100, 500),
                'read_count' => rand(50, 200),
                'creator_id' => $creatorId,
                'published_at' => now()->subDays(15),
            ],
            [
                'category_id' => $categories->random()->id,
                'city_id' => $cities->where('name', 'Bandung')->first()?->id ?? $cities->random()->id,
                'title' => 'Bandung Adventure Guide - Nature & Activities',
                'slug' => 'bandung-adventure-guide-' . Str::random(5),
                'description' => 'Experience the best outdoor activities in Bandung, from hiking volcanoes to exploring tea plantations. Perfect for adventure enthusiasts and nature lovers visiting the Paris of Java.',
                'page_count' => 160,
                'status' => 'published',
                'view_count' => rand(100, 500),
                'read_count' => rand(50, 200),
                'creator_id' => $creatorId,
                'published_at' => now()->subDays(12),
            ],
            [
                'category_id' => $categories->random()->id,
                'city_id' => $cities->where('name', 'Surabaya')->first()?->id ?? $cities->random()->id,
                'title' => 'Surabaya Explorer - City of Heroes',
                'slug' => 'surabaya-explorer-' . Str::random(5),
                'description' => 'Discover Surabaya\'s historical sites, modern attractions, and unique local experiences. From the House of Sampoerna to submarine museums, explore Indonesia\'s second-largest city.',
                'page_count' => 140,
                'status' => 'published',
                'view_count' => rand(100, 500),
                'read_count' => rand(50, 200),
                'creator_id' => $creatorId,
                'published_at' => now()->subDays(10),
            ],
            [
                'category_id' => $categories->random()->id,
                'city_id' => $cities->where('name', 'Malang')->first()?->id ?? $cities->random()->id,
                'title' => 'Malang Hidden Gems - Off the Beaten Path',
                'slug' => 'malang-hidden-gems-' . Str::random(5),
                'description' => 'Uncover Malang\'s secret spots, from colorful villages to stunning waterfalls and mountain retreats. A guide for travelers who want to explore beyond the usual tourist attractions.',
                'page_count' => 175,
                'status' => 'published',
                'view_count' => rand(100, 500),
                'read_count' => rand(50, 200),
                'creator_id' => $creatorId,
                'published_at' => now()->subDays(8),
            ],
            [
                'category_id' => $categories->random()->id,
                'city_id' => $cities->where('name', 'Semarang')->first()?->id ?? $cities->random()->id,
                'title' => 'Semarang Heritage Walk - Dutch Colonial Legacy',
                'slug' => 'semarang-heritage-walk-' . Str::random(5),
                'description' => 'Walk through Semarang\'s historic Old Town and discover Dutch colonial architecture, Chinese temples, and the unique blend of cultures that define this coastal city.',
                'page_count' => 145,
                'status' => 'published',
                'view_count' => rand(100, 500),
                'read_count' => rand(50, 200),
                'creator_id' => $creatorId,
                'published_at' => now()->subDays(5),
            ],
            [
                'category_id' => $categories->random()->id,
                'city_id' => $cities->where('name', 'Medan')->first()?->id ?? $cities->random()->id,
                'title' => 'Medan Food Trail - Taste of North Sumatra',
                'slug' => 'medan-food-trail-' . Str::random(5),
                'description' => 'A culinary journey through Medan\'s diverse food scene. From authentic Batak cuisine to Indian and Chinese influences, discover the flavors that make Medan a food lover\'s paradise.',
                'page_count' => 130,
                'status' => 'published',
                'view_count' => rand(100, 500),
                'read_count' => rand(50, 200),
                'creator_id' => $creatorId,
                'published_at' => now()->subDays(3),
            ],
            [
                'category_id' => $categories->random()->id,
                'city_id' => $cities->where('name', 'Palembang')->first()?->id ?? $cities->random()->id,
                'title' => 'Palembang River Life - Culture Along Musi River',
                'slug' => 'palembang-river-life-' . Str::random(5),
                'description' => 'Experience life along the Musi River, from the iconic Ampera Bridge to traditional floating markets. Discover Palembang\'s rich history as an ancient maritime kingdom.',
                'page_count' => 165,
                'status' => 'published',
                'view_count' => rand(100, 500),
                'read_count' => rand(50, 200),
                'creator_id' => $creatorId,
                'published_at' => now()->subDays(1),
            ],
        ];

        foreach ($ebooks as $ebookData) {
            Ebook::create($ebookData);
        }

        $this->command->info('✅ 10 ebooks created successfully!');
        $this->command->info('📚 Ebooks distributed across different cities');
    }
}
