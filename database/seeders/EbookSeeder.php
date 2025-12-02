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
        // Get first category and city, or create if not exist
        $category = Category::first();
        $city = City::first();
        $admin = User::where('email', 'admin@admin.com')->first();

        if (!$category) {
            $category = Category::create([
                'name' => 'Travel Guide',
                'slug' => 'travel-guide',
                'description' => 'Travel guides and tips'
            ]);
        }

        if (!$city) {
            $city = City::create([
                'name' => 'Surabaya',
                'slug' => 'surabaya'
            ]);
        }

        $categoryId = $category->id;
        $cityId = $city->id;
        $creatorId = $admin ? $admin->id : null;

        // Create 10 sample ebooks with realistic data
        $ebooks = [
            [
                'category_id' => $categoryId,
                'city_id' => $cityId,
                'title' => 'Complete Guide to Bali - Explore the Island of Gods',
                'slug' => 'complete-guide-to-bali-' . Str::random(5),
                'description' => 'Discover the most beautiful places in Bali, from stunning temples to pristine beaches. This comprehensive guide covers everything you need to know about Bali including best places to visit, local cuisine, accommodation tips, and cultural insights.',
                'author' => 'Made Wirawan',
                'page_count' => 150,
                'status' => 'published',
                'view_count' => rand(100, 500),
                'read_count' => rand(50, 200),
                'creator_id' => $creatorId,
                'published_at' => now()->subDays(30),
            ],
            [
                'category_id' => $categoryId,
                'city_id' => $cityId,
                'title' => 'Yogyakarta Cultural Heritage - History & Traditions',
                'slug' => 'yogyakarta-cultural-heritage-' . Str::random(5),
                'description' => 'Explore the rich cultural heritage of Yogyakarta, including Borobudur Temple, Prambanan, and traditional Javanese arts. Learn about the royal palace, batik making, and local traditions that make Yogyakarta unique.',
                'author' => 'Siti Nurhaliza',
                'page_count' => 200,
                'status' => 'published',
                'view_count' => rand(100, 500),
                'read_count' => rand(50, 200),
                'creator_id' => $creatorId,
                'published_at' => now()->subDays(25),
            ],
            [
                'category_id' => $categoryId,
                'city_id' => $cityId,
                'title' => 'Jakarta Street Food Adventure - Culinary Journey',
                'slug' => 'jakarta-street-food-adventure-' . Str::random(5),
                'description' => 'A complete guide to Jakarta\'s amazing street food scene, from traditional dishes to modern fusion cuisine. Discover hidden food stalls, popular restaurants, and must-try dishes in the capital city.',
                'author' => 'Chef Rudi Hartono',
                'page_count' => 120,
                'status' => 'published',
                'view_count' => rand(100, 500),
                'read_count' => rand(50, 200),
                'creator_id' => $creatorId,
                'published_at' => now()->subDays(20),
            ],
            [
                'category_id' => $categoryId,
                'city_id' => $cityId,
                'title' => 'Lombok Island Paradise - Beaches & Waterfalls',
                'slug' => 'lombok-island-paradise-' . Str::random(5),
                'description' => 'Discover Lombok\'s hidden gems, from stunning beaches to majestic waterfalls and Mount Rinjani. A complete guide for travelers seeking pristine nature and adventure activities.',
                'author' => 'Andi Saputra',
                'page_count' => 180,
                'status' => 'published',
                'view_count' => rand(100, 500),
                'read_count' => rand(50, 200),
                'creator_id' => $creatorId,
                'published_at' => now()->subDays(15),
            ],
            [
                'category_id' => $categoryId,
                'city_id' => $cityId,
                'title' => 'Bandung Adventure Guide - Nature & Activities',
                'slug' => 'bandung-adventure-guide-' . Str::random(5),
                'description' => 'Experience the best outdoor activities in Bandung, from hiking volcanoes to exploring tea plantations. Perfect for adventure enthusiasts and nature lovers visiting the Paris of Java.',
                'author' => 'Dimas Prasetyo',
                'page_count' => 160,
                'status' => 'draft',
                'view_count' => 0,
                'read_count' => 0,
                'creator_id' => $creatorId,
                'published_at' => null,
            ],
            [
                'category_id' => $categoryId,
                'city_id' => $cityId,
                'title' => 'Surabaya Explorer - City of Heroes',
                'slug' => 'surabaya-explorer-' . Str::random(5),
                'description' => 'Discover Surabaya\'s historical sites, modern attractions, and unique local experiences. From the House of Sampoerna to submarine museums, explore Indonesia\'s second-largest city.',
                'author' => 'Budi Santoso',
                'page_count' => 140,
                'status' => 'published',
                'view_count' => rand(100, 500),
                'read_count' => rand(50, 200),
                'creator_id' => $creatorId,
                'published_at' => now()->subDays(10),
            ],
            [
                'category_id' => $categoryId,
                'city_id' => $cityId,
                'title' => 'Malang Hidden Gems - Off the Beaten Path',
                'slug' => 'malang-hidden-gems-' . Str::random(5),
                'description' => 'Uncover Malang\'s secret spots, from colorful villages to stunning waterfalls and mountain retreats. A guide for travelers who want to explore beyond the usual tourist attractions.',
                'author' => 'Ayu Lestari',
                'page_count' => 175,
                'status' => 'waiting_approval',
                'view_count' => 0,
                'read_count' => 0,
                'creator_id' => $creatorId,
                'published_at' => null,
            ],
            [
                'category_id' => $categoryId,
                'city_id' => $cityId,
                'title' => 'Raja Ampat Diving Paradise - Underwater Wonders',
                'slug' => 'raja-ampat-diving-paradise-' . Str::random(5),
                'description' => 'Explore the world\'s most biodiverse marine ecosystem in Raja Ampat. Complete diving guide with best spots, marine life identification, and practical travel tips for divers.',
                'author' => 'Dr. Marina Kusuma',
                'page_count' => 220,
                'status' => 'published',
                'view_count' => rand(100, 500),
                'read_count' => rand(50, 200),
                'creator_id' => $creatorId,
                'published_at' => now()->subDays(5),
            ],
            [
                'category_id' => $categoryId,
                'city_id' => $cityId,
                'title' => 'Medan Food Trail - Taste of North Sumatra',
                'slug' => 'medan-food-trail-' . Str::random(5),
                'description' => 'A culinary journey through Medan\'s diverse food scene. From authentic Batak cuisine to Indian and Chinese influences, discover the flavors that make Medan a food lover\'s paradise.',
                'author' => 'Chef Tommy Wijaya',
                'page_count' => 130,
                'status' => 'unpublished',
                'view_count' => rand(50, 150),
                'read_count' => rand(20, 80),
                'creator_id' => $creatorId,
                'published_at' => null,
            ],
            [
                'category_id' => $categoryId,
                'city_id' => $cityId,
                'title' => 'Komodo National Park - Dragons and Beyond',
                'slug' => 'komodo-national-park-' . Str::random(5),
                'description' => 'Experience the legendary Komodo dragons in their natural habitat. This guide covers everything about Komodo National Park, from wildlife encounters to island hopping and snorkeling adventures.',
                'author' => 'Agus Setiawan',
                'page_count' => 195,
                'status' => 'published',
                'view_count' => rand(100, 500),
                'read_count' => rand(50, 200),
                'creator_id' => $creatorId,
                'published_at' => now()->subDays(2),
            ],
        ];

        foreach ($ebooks as $ebookData) {
            Ebook::create($ebookData);
        }

        $this->command->info('10 ebooks created successfully!');
    }
}
