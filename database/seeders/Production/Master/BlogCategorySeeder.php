<?php

namespace Database\Seeders\Production\Master;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BlogCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $blogCategories = [
            [
                'name' => 'Travel Tips',
                'slug' => 'blog-travel-tips',
                'description' => 'Tips dan trik perjalanan untuk wisatawan',
                'type' => 'blog',
                'is_active' => true,
            ],
            [
                'name' => 'Destination Guide',
                'slug' => 'blog-destination-guide',
                'description' => 'Panduan lengkap destinasi wisata',
                'type' => 'blog',
                'is_active' => true,
            ],
            [
                'name' => 'Food & Culture',
                'slug' => 'blog-food-culture',
                'description' => 'Kuliner dan budaya lokal',
                'type' => 'blog',
                'is_active' => true,
            ],
            [
                'name' => 'Adventure Travel',
                'slug' => 'blog-adventure-travel',
                'description' => 'Petualangan dan aktivitas outdoor',
                'type' => 'blog',
                'is_active' => true,
            ],
            [
                'name' => 'Budget Travel',
                'slug' => 'blog-budget-travel',
                'description' => 'Traveling hemat dan backpacking',
                'type' => 'blog',
                'is_active' => true,
            ],
            [
                'name' => 'Luxury Travel',
                'slug' => 'blog-luxury-travel',
                'description' => 'Perjalanan mewah dan premium',
                'type' => 'blog',
                'is_active' => true,
            ],
            [
                'name' => 'Family Travel',
                'slug' => 'blog-family-travel',
                'description' => 'Tips traveling bersama keluarga',
                'type' => 'blog',
                'is_active' => true,
            ],
            [
                'name' => 'Solo Travel',
                'slug' => 'blog-solo-travel',
                'description' => 'Panduan traveling sendiri',
                'type' => 'blog',
                'is_active' => true,
            ],
            [
                'name' => 'Hotel & Accommodation',
                'slug' => 'blog-hotel-accommodation',
                'description' => 'Review hotel dan penginapan',
                'type' => 'blog',
                'is_active' => true,
            ],
            [
                'name' => 'Transportation',
                'slug' => 'blog-transportation',
                'description' => 'Panduan transportasi dan mobilitas',
                'type' => 'blog',
                'is_active' => true,
            ],
            [
                'name' => 'Photography',
                'slug' => 'blog-photography',
                'description' => 'Tips fotografi perjalanan',
                'type' => 'blog',
                'is_active' => true,
            ],
            [
                'name' => 'Visa & Immigration',
                'slug' => 'blog-visa-immigration',
                'description' => 'Informasi visa dan imigrasi',
                'type' => 'blog',
                'is_active' => true,
            ],
            [
                'name' => 'Travel News',
                'slug' => 'blog-travel-news',
                'description' => 'Berita dan update dunia travel',
                'type' => 'blog',
                'is_active' => true,
            ],
            [
                'name' => 'Hidden Gems',
                'slug' => 'blog-hidden-gems',
                'description' => 'Tempat-tempat tersembunyi yang wajib dikunjungi',
                'type' => 'blog',
                'is_active' => true,
            ],
            [
                'name' => 'Beach & Island',
                'slug' => 'blog-beach-island',
                'description' => 'Wisata pantai dan pulau',
                'type' => 'blog',
                'is_active' => true,
            ],
            [
                'name' => 'Mountain & Hiking',
                'slug' => 'blog-mountain-hiking',
                'description' => 'Pendakian gunung dan hiking',
                'type' => 'blog',
                'is_active' => true,
            ],
            [
                'name' => 'City Guide',
                'slug' => 'blog-city-guide',
                'description' => 'Panduan lengkap kota-kota dunia',
                'type' => 'blog',
                'is_active' => true,
            ],
            [
                'name' => 'Festivals & Events',
                'slug' => 'blog-festivals-events',
                'description' => 'Festival dan acara wisata',
                'type' => 'blog',
                'is_active' => true,
            ],
            [
                'name' => 'Travel Gear',
                'slug' => 'blog-travel-gear',
                'description' => 'Perlengkapan dan gadget traveling',
                'type' => 'blog',
                'is_active' => true,
            ],
            [
                'name' => 'Sustainable Travel',
                'slug' => 'blog-sustainable-travel',
                'description' => 'Eco-tourism dan traveling berkelanjutan',
                'type' => 'blog',
                'is_active' => true,
            ],
        ];

        foreach ($blogCategories as $category) {
            $existing = Category::where('slug', $category['slug'])
                ->where('type', 'blog')
                ->first();
            
            if ($existing) {
                $existing->update($category);
            } else {
                Category::create($category);
            }
        }

        $this->command->info('✅ Blog categories seeded successfully!');
        $this->command->info('   Total: ' . count($blogCategories) . ' blog categories');
    }
}
