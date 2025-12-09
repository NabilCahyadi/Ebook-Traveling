<?php

namespace Database\Seeders;

use App\Models\Collection;
use App\Models\Ebook;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CollectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan ada ebook yang sudah published
        $publishedEbooks = Ebook::where('status', 'published')->get();

        if ($publishedEbooks->isEmpty()) {
            $this->command->warn('Tidak ada ebook dengan status published. Collection tidak bisa dibuat.');
            return;
        }

        // Definisi collection yang akan dibuat
        $collections = [
            [
                'name' => 'Best Sellers',
                'slug' => 'best-sellers',
                'description' => 'Most popular ebooks loved by our readers',
                'order_index' => 1,
                'is_active' => true,
                'show_in_homepage' => true,
            ],
            [
                'name' => 'New Releases',
                'slug' => 'new-releases',
                'description' => 'Latest ebooks added to our collection',
                'order_index' => 2,
                'is_active' => true,
                'show_in_homepage' => true,
            ],
            [
                'name' => 'Travel Guides',
                'slug' => 'travel-guides',
                'description' => 'Complete guides for your travel destinations',
                'order_index' => 3,
                'is_active' => true,
                'show_in_homepage' => true,
            ],
            [
                'name' => 'Adventure Stories',
                'slug' => 'adventure-stories',
                'description' => 'Exciting adventure and exploration stories',
                'order_index' => 4,
                'is_active' => true,
                'show_in_homepage' => true,
            ],
            [
                'name' => 'Budget Travel',
                'slug' => 'budget-travel',
                'description' => 'Travel tips and guides for budget travelers',
                'order_index' => 5,
                'is_active' => true,
                'show_in_homepage' => true,
            ],
            [
                'name' => 'Luxury Destinations',
                'slug' => 'luxury-destinations',
                'description' => 'Premium travel experiences and luxury destinations',
                'order_index' => 6,
                'is_active' => true,
                'show_in_homepage' => false, // Tidak tampil di homepage
            ],
        ];

        foreach ($collections as $collectionData) {
            // Buat atau update collection
            $collection = Collection::updateOrCreate(
                ['slug' => $collectionData['slug']],
                $collectionData
            );

            // Attach random ebooks ke collection (maksimal 10 ebook per collection)
            $randomEbooks = $publishedEbooks->random(min(10, $publishedEbooks->count()));

            $ebookIds = [];
            foreach ($randomEbooks as $index => $ebook) {
                $ebookIds[$ebook->id] = [
                    'id' => (string) \Illuminate\Support\Str::uuid(), // Generate UUID untuk pivot table
                    'order_index' => $index + 1
                ];
            }

            // Sync ebooks ke collection
            $collection->ebooks()->sync($ebookIds);

            $this->command->info("Collection '{$collection->name}' created with " . count($ebookIds) . " ebooks.");
        }

        $this->command->info('Collection seeding completed!');
    }
}
