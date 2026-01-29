<?php

namespace Database\Seeders\Production\Master;

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
                'image' => 'https://skillup-ecourse.sgp1.cdn.digitaloceanspaces.com/meet/category/1752726499-1752726499.png' // Tambahkan URL
            ],
            [
                'name' => 'Budaya & Sejarah',
                'slug' => 'budaya-sejarah',
                'description' => 'Informasi budaya dan sejarah kota-kota di dunia',
                'image' => 'https://skillup-ecourse.sgp1.cdn.digitaloceanspaces.com/meet/category/1752726463-1752726463.png'
            ],
            [
                'name' => 'Kuliner',
                'slug' => 'kuliner',
                'description' => 'Panduan kuliner dan makanan khas daerah',
                'image' => 'https://skillup-ecourse.sgp1.cdn.digitaloceanspaces.com/meet/category/1752726445-1752726445.png'
            ],
            [
                'name' => 'Akomodasi',
                'slug' => 'akomodasi',
                'description' => 'Panduan hotel dan penginapan',
                'image' => 'https://skillup-ecourse.sgp1.cdn.digitaloceanspaces.com/meet/category/1752726515-1752726515.png'
            ],
            [
                'name' => 'Transportasi',
                'slug' => 'transportasi',
                'description' => 'Informasi transportasi dan cara berpergian',
                'image' => 'https://skillup-ecourse.sgp1.cdn.digitaloceanspaces.com/meet/category/1752726515-1752726515.png'
            ],
            [
                'name' => 'Wisata Alam',
                'slug' => 'wisata-alam',
                'description' => 'Panduan wisata alam, gunung, dan pantai',
                'image' => 'https://skillup-ecourse.sgp1.cdn.digitaloceanspaces.com/meet/category/1752726534-1752726534.png'
            ],
            [
                'name' => 'Petualangan',
                'slug' => 'petualangan',
                'description' => 'Aktivitas petualangan dan olahraga ekstrim',
                'image' => 'https://skillup-ecourse.sgp1.cdn.digitaloceanspaces.com/meet/category/1752726534-1752726534.png'
            ],
            [
                'name' => 'Tips & Trik',
                'slug' => 'tips-trik',
                'description' => 'Tips dan trik traveling',
                'image' => 'https://skillup-ecourse.sgp1.cdn.digitaloceanspaces.com/meet/category/1752726534-1752726534.png'
            ],
            [
                'name' => 'Budget Travel',
                'slug' => 'budget-travel',
                'description' => 'Panduan traveling dengan budget hemat',
                'image' => 'https://skillup-ecourse.sgp1.cdn.digitaloceanspaces.com/meet/category/1752726570-1752726570.png'
            ],
            [
                'name' => 'Luxury Travel',
                'slug' => 'luxury-travel',
                'description' => 'Panduan traveling mewah dan premium',
                'image' => 'https://skillup-ecourse.sgp1.cdn.digitaloceanspaces.com/meet/category/1752726586-1752726586.png'
            ],
            [
                'name' => 'Wisata Religi',
                'slug' => 'wisata-religi',
                'description' => 'Panduan wisata religi dan spiritual',
                'image' => 'https://skillup-ecourse.sgp1.cdn.digitaloceanspaces.com/meet/category/1752726499-1752726499.png'
            ],
            [
                'name' => 'Wisata Edukasi',
                'slug' => 'wisata-edukasi',
                'description' => 'Destinasi wisata edukatif dan museum',
                'image' => 'https://skillup-ecourse.sgp1.cdn.digitaloceanspaces.com/meet/category/1752726534-1752726534.png'
            ],
            [
                'name' => 'Belanja & Shopping',
                'slug' => 'belanja-shopping',
                'description' => 'Panduan belanja dan pusat perbelanjaan',
                'image' => 'https://skillup-ecourse.sgp1.cdn.digitaloceanspaces.com/meet/category/1752726534-1752726534.png'
            ],
            [
                'name' => 'Kehidupan Malam',
                'slug' => 'kehidupan-malam',
                'description' => 'Panduan hiburan malam dan nightlife',
                'image' => 'https://skillup-ecourse.sgp1.cdn.digitaloceanspaces.com/meet/category/1752726534-1752726534.png'
            ],
            [
                'name' => 'Family Travel',
                'slug' => 'family-travel',
                'description' => 'Panduan traveling bersama keluarga',
                'image' => 'https://skillup-ecourse.sgp1.cdn.digitaloceanspaces.com/meet/category/1752726534-1752726534.png'
            ],
            [
                'name' => 'Wisata Anak',
                'slug' => 'wisata-anak',
                'description' => 'Destinasi wisata ramah anak',
                'image' => 'https://skillup-ecourse.sgp1.cdn.digitaloceanspaces.com/meet/category/1752726534-1752726534.png'
            ],
            [
                'name' => 'Fotografi',
                'slug' => 'fotografi',
                'description' => 'Spot foto terbaik dan tips fotografi travel',
                'image' => 'https://skillup-ecourse.sgp1.cdn.digitaloceanspaces.com/meet/category/1752726534-1752726534.png'
            ],
            [
                'name' => 'Musim & Festival',
                'slug' => 'musim-festival',
                'description' => 'Panduan festival dan event musiman',
                'image' => 'https://skillup-ecourse.sgp1.cdn.digitaloceanspaces.com/meet/category/1752726534-1752726534.png'
            ],
            [
                'name' => 'Kesehatan & Keamanan',
                'slug' => 'kesehatan-keamanan',
                'description' => 'Tips kesehatan dan keamanan saat traveling',
                'image' => 'https://skillup-ecourse.sgp1.cdn.digitaloceanspaces.com/meet/category/1752726534-1752726534.png'
            ],
            [
                'name' => 'Digital Nomad',
                'slug' => 'digital-nomad',
                'description' => 'Panduan untuk bekerja sambil traveling',
                'image' => 'https://skillup-ecourse.sgp1.cdn.digitaloceanspaces.com/meet/category/1752726499-1752726499.png'
            ],
        ];

        foreach ($categories as $categoryData) {
            // Ambil URL gambar dari array
            $imageUrl = $categoryData['image'];

            // Gabungkan data awal dengan data tambahan (id, image, type, dll.)
            $fullData = array_merge($categoryData, [
                'id' => Str::uuid(),
                'image' => $imageUrl, // Gunakan URL langsung
                'type' => 'ebook',
                'parent_id' => null,
                'is_active' => true,
            ]);

            Category::create($fullData);
        }

        $this->command->info('✅ Categories seeded successfully!');
        $this->command->info('📚 Total: ' . count($categories) . ' categories created');
    }
}
