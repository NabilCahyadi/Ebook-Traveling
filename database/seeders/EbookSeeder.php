<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\EbookCategory;
use App\Models\City;
use App\Models\Ebook;
use Illuminate\Support\Str;

class EbookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Categories
        $categories = [
            ['name' => 'Travel Guide', 'slug' => 'travel-guide'],
            ['name' => 'Culture & History', 'slug' => 'culture-history'],
            ['name' => 'Food & Culinary', 'slug' => 'food-culinary'],
            ['name' => 'Adventure', 'slug' => 'adventure'],
            ['name' => 'Beach & Island', 'slug' => 'beach-island'],
        ];

        foreach ($categories as $category) {
            EbookCategory::create($category);
        }

        // Create Cities
        $cities = [
            ['name' => 'Bali', 'country' => 'Indonesia'],
            ['name' => 'Jakarta', 'country' => 'Indonesia'],
            ['name' => 'Yogyakarta', 'country' => 'Indonesia'],
            ['name' => 'Bandung', 'country' => 'Indonesia'],
            ['name' => 'Lombok', 'country' => 'Indonesia'],
            ['name' => 'Surabaya', 'country' => 'Indonesia'],
            ['name' => 'Tokyo', 'country' => 'Japan'],
            ['name' => 'Paris', 'country' => 'France'],
        ];

        foreach ($cities as $city) {
            City::create($city);
        }

        // Create Sample Ebooks
        $ebooks = [
            [
                'category_id' => 1,
                'city_id' => 1,
                'title' => 'Complete Guide to Bali - Explore the Island of Gods',
                'slug' => 'complete-guide-to-bali',
                'description' => 'Discover the most beautiful places in Bali, from stunning temples to pristine beaches. This comprehensive guide covers everything you need to know about Bali.',
                'cover_image' => 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=400',
                'file_url' => null,
                'preview_content' => 'Bali is a tropical paradise known for its beautiful beaches, ancient temples, and vibrant culture...',
                'is_active' => true,
            ],
            [
                'category_id' => 2,
                'city_id' => 3,
                'title' => 'Yogyakarta Cultural Heritage - History & Traditions',
                'slug' => 'yogyakarta-cultural-heritage',
                'description' => 'Explore the rich cultural heritage of Yogyakarta, including Borobudur Temple, Prambanan, and traditional Javanese arts.',
                'cover_image' => 'https://images.unsplash.com/photo-1588668214407-6ea9a6d8c272?w=400',
                'file_url' => null,
                'preview_content' => 'Yogyakarta is the cultural heart of Java, home to magnificent temples and living traditions...',
                'is_active' => true,
            ],
            [
                'category_id' => 3,
                'city_id' => 2,
                'title' => 'Jakarta Street Food Adventure - Culinary Journey',
                'slug' => 'jakarta-street-food-adventure',
                'description' => 'A complete guide to Jakarta\'s amazing street food scene, from traditional dishes to modern fusion cuisine.',
                'cover_image' => 'https://images.unsplash.com/photo-1504674900247-0877df9cc836?w=400',
                'file_url' => null,
                'preview_content' => 'Jakarta offers an incredible variety of street food that reflects its diverse culture...',
                'is_active' => true,
            ],
            [
                'category_id' => 5,
                'city_id' => 5,
                'title' => 'Lombok Island Paradise - Beaches & Waterfalls',
                'slug' => 'lombok-island-paradise',
                'description' => 'Discover Lombok\'s hidden gems, from stunning beaches to majestic waterfalls and Mount Rinjani.',
                'cover_image' => 'https://images.unsplash.com/photo-1559827260-dc66d52bef19?w=400',
                'file_url' => null,
                'preview_content' => 'Lombok is a pristine island paradise offering tranquil beaches and natural wonders...',
                'is_active' => true,
            ],
            [
                'category_id' => 4,
                'city_id' => 4,
                'title' => 'Bandung Adventure Guide - Nature & Activities',
                'slug' => 'bandung-adventure-guide',
                'description' => 'Experience the best outdoor activities in Bandung, from hiking volcanoes to exploring tea plantations.',
                'cover_image' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=400',
                'file_url' => null,
                'preview_content' => 'Bandung is surrounded by stunning natural landscapes perfect for adventure seekers...',
                'is_active' => true,
            ],
            [
                'category_id' => 1,
                'city_id' => 7,
                'title' => 'Tokyo Travel Guide - Modern Meets Traditional',
                'slug' => 'tokyo-travel-guide',
                'description' => 'Navigate Tokyo like a local with this comprehensive guide to Japan\'s bustling capital city.',
                'cover_image' => 'https://images.unsplash.com/photo-1540959733332-eab4deabeeaf?w=400',
                'file_url' => null,
                'preview_content' => 'Tokyo is a fascinating blend of ancient traditions and cutting-edge modernity...',
                'is_active' => true,
            ],
            [
                'category_id' => 2,
                'city_id' => 8,
                'title' => 'Paris Historical Journey - Art & Architecture',
                'slug' => 'paris-historical-journey',
                'description' => 'Explore Paris\' magnificent history, from the Louvre to Notre-Dame and beyond.',
                'cover_image' => 'https://images.unsplash.com/photo-1502602898657-3e91760cbb34?w=400',
                'file_url' => null,
                'preview_content' => 'Paris is a living museum with centuries of art, culture, and architectural marvels...',
                'is_active' => true,
            ],
            [
                'category_id' => 1,
                'city_id' => 6,
                'title' => 'Surabaya Explorer - City of Heroes',
                'slug' => 'surabaya-explorer',
                'description' => 'Discover Surabaya\'s historical sites, modern attractions, and unique local experiences.',
                'cover_image' => 'https://images.unsplash.com/photo-1480714378408-67cf0d13bc1b?w=400',
                'file_url' => null,
                'preview_content' => 'Surabaya is Indonesia\'s second-largest city with a rich history and vibrant culture...',
                'is_active' => true,
            ],
        ];

        foreach ($ebooks as $ebook) {
            Ebook::create($ebook);
        }
    }
}
