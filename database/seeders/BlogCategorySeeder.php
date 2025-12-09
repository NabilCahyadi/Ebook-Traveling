<?php

namespace Database\Seeders;

use App\Models\BlogCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BlogCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Travel Tips',
                'slug' => 'travel-tips',
                'description' => 'Helpful tips and advice for travelers',
                'is_active' => true,
            ],
            [
                'name' => 'Destination Guides',
                'slug' => 'destination-guides',
                'description' => 'Comprehensive guides to travel destinations',
                'is_active' => true,
            ],
            [
                'name' => 'Food & Culture',
                'slug' => 'food-culture',
                'description' => 'Explore local cuisine and cultural experiences',
                'is_active' => true,
            ],
            [
                'name' => 'Adventure Travel',
                'slug' => 'adventure-travel',
                'description' => 'Exciting adventures and outdoor activities',
                'is_active' => true,
            ],
            [
                'name' => 'Budget Travel',
                'slug' => 'budget-travel',
                'description' => 'Travel on a budget with money-saving tips',
                'is_active' => true,
            ],
            [
                'name' => 'Luxury Travel',
                'slug' => 'luxury-travel',
                'description' => 'Premium travel experiences and destinations',
                'is_active' => true,
            ],
            [
                'name' => 'Solo Travel',
                'slug' => 'solo-travel',
                'description' => 'Tips and stories for solo travelers',
                'is_active' => true,
            ],
            [
                'name' => 'Family Travel',
                'slug' => 'family-travel',
                'description' => 'Family-friendly destinations and activities',
                'is_active' => true,
            ],
            [
                'name' => 'Digital Nomad',
                'slug' => 'digital-nomad',
                'description' => 'Tips for working while traveling',
                'is_active' => true,
            ],
            [
                'name' => 'Photography',
                'slug' => 'photography',
                'description' => 'Travel photography tips and inspiration',
                'is_active' => true,
            ],
        ];

        foreach ($categories as $category) {
            BlogCategory::firstOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }

        $this->command->info('Blog categories seeded successfully!');
    }
}
