<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            // Travel & Tourism
            [
                'name' => 'Panduan Wisata',
                'slug' => 'panduan-wisata',
                'description' => 'Panduan lengkap destinasi wisata di berbagai kota',
                'type' => 'ebook',
                'parent_id' => null,
                'is_active' => true,
            ],
            ['name' => 'Budaya & Sejarah', 'slug' => 'budaya-sejarah', 'description' => 'Informasi budaya dan sejarah kota-kota di dunia', 'type' => 'ebook', 'is_active' => true],
            ['name' => 'Kuliner', 'slug' => 'kuliner', 'description' => 'Panduan kuliner dan makanan khas daerah', 'type' => 'ebook', 'is_active' => true],
            ['name' => 'Akomodasi', 'slug' => 'akomodasi', 'description' => 'Panduan hotel dan penginapan', 'type' => 'ebook', 'is_active' => true],
            ['name' => 'Transportasi', 'slug' => 'transportasi', 'description' => 'Informasi transportasi dan cara berpergian', 'type' => 'ebook', 'is_active' => true],
            ['name' => 'Wisata Alam', 'slug' => 'wisata-alam', 'description' => 'Panduan wisata alam, gunung, dan pantai', 'type' => 'ebook', 'is_active' => true],
            ['name' => 'Petualangan', 'slug' => 'petualangan', 'description' => 'Aktivitas petualangan dan olahraga ekstrim', 'type' => 'ebook', 'is_active' => true],
            ['name' => 'Tips & Trik', 'slug' => 'tips-trik', 'description' => 'Tips dan trik traveling', 'type' => 'ebook', 'is_active' => true],
            ['name' => 'Budget Travel', 'slug' => 'budget-travel', 'description' => 'Panduan traveling dengan budget hemat', 'type' => 'ebook', 'is_active' => true],
            ['name' => 'Luxury Travel', 'slug' => 'luxury-travel', 'description' => 'Panduan traveling mewah dan premium', 'type' => 'ebook', 'is_active' => true],
            ['name' => 'Wisata Religi', 'slug' => 'wisata-religi', 'description' => 'Panduan wisata religi dan spiritual', 'type' => 'ebook', 'is_active' => true],
            ['name' => 'Wisata Edukasi', 'slug' => 'wisata-edukasi', 'description' => 'Destinasi wisata edukatif dan museum', 'type' => 'ebook', 'is_active' => true],
            ['name' => 'Belanja & Shopping', 'slug' => 'belanja-shopping', 'description' => 'Panduan belanja dan pusat perbelanjaan', 'type' => 'ebook', 'is_active' => true],
            ['name' => 'Kehidupan Malam', 'slug' => 'kehidupan-malam', 'description' => 'Panduan hiburan malam dan nightlife', 'type' => 'ebook', 'is_active' => true],
            ['name' => 'Family Travel', 'slug' => 'family-travel', 'description' => 'Panduan traveling bersama keluarga', 'type' => 'ebook', 'is_active' => true],
            ['name' => 'Wisata Anak', 'slug' => 'wisata-anak', 'description' => 'Destinasi wisata ramah anak', 'type' => 'ebook', 'is_active' => true],
            ['name' => 'Fotografi', 'slug' => 'fotografi', 'description' => 'Spot foto terbaik dan tips fotografi travel', 'type' => 'ebook', 'is_active' => true],
            ['name' => 'Musim & Festival', 'slug' => 'musim-festival', 'description' => 'Panduan festival dan event musiman', 'type' => 'ebook', 'is_active' => true],
            ['name' => 'Kesehatan & Keamanan', 'slug' => 'kesehatan-keamanan', 'description' => 'Tips kesehatan dan keamanan saat traveling', 'type' => 'ebook', 'is_active' => true],
            ['name' => 'Digital Nomad', 'slug' => 'digital-nomad', 'description' => 'Panduan untuk bekerja sambil traveling', 'type' => 'ebook', 'is_active' => true],
        ];

        foreach ($categories as $category) {
            Category::create(array_merge(['id' => Str::uuid()], $category));
        }

        $this->command->info('✅ Categories seeded successfully!');
        $this->command->info('📚 Total: ' . count($categories) . ' categories created');
    }
}
