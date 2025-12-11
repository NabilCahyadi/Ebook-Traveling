<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Models\Collection;

class CollectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $collections = [
            [
                'name' => 'Best Seller',
                'slug' => 'best-seller',
                'description' => 'Koleksi ebook paling laris dan populer.',
                'order' => 1,
                'is_visible_on_landing' => 1,
                'order_index' => 1,
                'is_active' => 1,
                'show_in_homepage' => 1,
            ],
            [
                'name' => 'Featured Collection',
                'slug' => 'featured-collection',
                'description' => 'Koleksi pilihan dari tim editorial kami yang wajib dibaca.',
                'order' => 2,
                'is_visible_on_landing' => 1,
                'order_index' => 2,
                'is_active' => 0,
                'show_in_homepage' => 1,
            ],
            [
                'name' => 'Latest',
                'slug' => 'latest',
                'description' => 'Koleksi ebook terbaru yang baru saja rilis.',
                'order' => 3,
                'is_visible_on_landing' => 1,
                'order_index' => 3,
                'is_active' => 1,
                'show_in_homepage' => 1,
            ],
        ];

        // Gunakan firstOrCreate untuk setiap koleksi
        foreach ($collections as $collectionData) {
            Collection::firstOrCreate(
                ['slug' => $collectionData['slug']], // Atribut untuk mencari
                $collectionData // Atribut untuk dibuat jika tidak ditemukan
            );
        }
    }
}
