<?php

namespace Database\Seeders\Production\Website;

use Illuminate\Database\Seeder;
use App\Models\LandingPageSection;
use App\Models\Collection;

class LandingPageSectionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing sections
        LandingPageSection::truncate();

        $sections = [];
        $order = 0;

        // 1. Hero Banner
        $sections[] = [
            'section_type' => LandingPageSection::TYPE_HERO_BANNER,
            'section_name' => 'Hero Banner',
            'reference_id' => null,
            'order' => $order++,
            'is_visible' => true,
            'config' => json_encode([
                'show_search' => true,
                'show_cta' => true
            ]),
            'created_at' => now(),
            'updated_at' => now()
        ];

        // 2. Top Cities
        $sections[] = [
            'section_type' => LandingPageSection::TYPE_TOP_CITIES,
            'section_name' => 'Top City Guides',
            'reference_id' => null,
            'order' => $order++,
            'is_visible' => true,
            'config' => json_encode([
                'limit' => 10,
                'show_view_all' => true
            ]),
            'created_at' => now(),
            'updated_at' => now()
        ];

        // 3. Collections - Add each active collection
        $collections = Collection::active()->orderBy('order', 'asc')->get();
        foreach ($collections as $collection) {
            $sections[] = [
                'section_type' => LandingPageSection::TYPE_COLLECTION,
                'section_name' => $collection->name,
                'reference_id' => $collection->id,
                'order' => $order++,
                'is_visible' => $collection->is_visible_on_landing ?? true,
                'config' => json_encode([
                    'limit' => 10,
                    'show_view_all' => true
                ]),
                'created_at' => now(),
                'updated_at' => now()
            ];
        }

        // 4. Subscription Plans
        $sections[] = [
            'section_type' => LandingPageSection::TYPE_SUBSCRIPTION_PLANS,
            'section_name' => 'Subscription Plans',
            'reference_id' => null,
            'order' => $order++,
            'is_visible' => true,
            'config' => json_encode([
                'limit' => 3,
                'show_features' => true
            ]),
            'created_at' => now(),
            'updated_at' => now()
        ];

        // 5. Latest Blogs
        $sections[] = [
            'section_type' => LandingPageSection::TYPE_LATEST_BLOGS,
            'section_name' => 'Latest Blogs',
            'reference_id' => null,
            'order' => $order++,
            'is_visible' => true,
            'config' => json_encode([
                'limit' => 4,
                'show_view_all' => true
            ]),
            'created_at' => now(),
            'updated_at' => now()
        ];

        // Insert all sections
        LandingPageSection::insert($sections);

        $this->command->info("Successfully seeded " . count($sections) . " landing page sections.");
    }
}
