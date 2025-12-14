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
                'image' => 'https://picsum.photos/seed/panduan-wisata/200/200.jpg' // Tambahkan URL
            ],
            [
                'name' => 'Budaya & Sejarah',
                'slug' => 'budaya-sejarah',
                'description' => 'Informasi budaya dan sejarah kota-kota di dunia',
                'image' => 'https://picsum.photos/seed/budaya-sejarah/200/200.jpg'
            ],
            [
                'name' => 'Kuliner',
                'slug' => 'kuliner',
                'description' => 'Panduan kuliner dan makanan khas daerah',
                'image' => 'https://picsum.photos/seed/kuliner/200/200.jpg'
            ],
            [
                'name' => 'Akomodasi',
                'slug' => 'akomodasi',
                'description' => 'Panduan hotel dan penginapan',
                'image' => 'https://picsum.photos/seed/akomodasi/200/200.jpg'
            ],
            [
                'name' => 'Transportasi',
                'slug' => 'transportasi',
                'description' => 'Informasi transportasi dan cara berpergian',
                'image' => 'https://picsum.photos/seed/transportasi/200/200.jpg'
            ],
            [
                'name' => 'Wisata Alam',
                'slug' => 'wisata-alam',
                'description' => 'Panduan wisata alam, gunung, dan pantai',
                'image' => 'https://picsum.photos/seed/wisata-alam/200/200.jpg'
            ],
            [
                'name' => 'Petualangan',
                'slug' => 'petualangan',
                'description' => 'Aktivitas petualangan dan olahraga ekstrim',
                'image' => 'https://picsum.photos/seed/petualangan/200/200.jpg'
            ],
            [
                'name' => 'Tips & Trik',
                'slug' => 'tips-trik',
                'description' => 'Tips dan trik traveling',
                'image' => 'https://picsum.photos/seed/tips-trik/200/200.jpg'
            ],
            [
                'name' => 'Budget Travel',
                'slug' => 'budget-travel',
                'description' => 'Panduan traveling dengan budget hemat',
                'image' => 'https://picsum.photos/seed/budget-travel/200/200.jpg'
            ],
            [
                'name' => 'Luxury Travel',
                'slug' => 'luxury-travel',
                'description' => 'Panduan traveling mewah dan premium',
                'image' => 'https://picsum.photos/seed/luxury-travel/200/200.jpg'
            ],
            [
                'name' => 'Wisata Religi',
                'slug' => 'wisata-religi',
                'description' => 'Panduan wisata religi dan spiritual',
                'image' => 'https://picsum.photos/seed/wisata-religi/200/200.jpg'
            ],
            [
                'name' => 'Wisata Edukasi',
                'slug' => 'wisata-edukasi',
                'description' => 'Destinasi wisata edukatif dan museum',
                'image' => 'https://picsum.photos/seed/wisata-edukasi/200/200.jpg'
            ],
            [
                'name' => 'Belanja & Shopping',
                'slug' => 'belanja-shopping',
                'description' => 'Panduan belanja dan pusat perbelanjaan',
                'image' => 'https://picsum.photos/seed/belanja-shopping/200/200.jpg'
            ],
            [
                'name' => 'Kehidupan Malam',
                'slug' => 'kehidupan-malam',
                'description' => 'Panduan hiburan malam dan nightlife',
                'image' => 'https://picsum.photos/seed/kehidupan-malam/200/200.jpg'
            ],
            [
                'name' => 'Family Travel',
                'slug' => 'family-travel',
                'description' => 'Panduan traveling bersama keluarga',
                'image' => 'https://picsum.photos/seed/family-travel/200/200.jpg'
            ],
            [
                'name' => 'Wisata Anak',
                'slug' => 'wisata-anak',
                'description' => 'Destinasi wisata ramah anak',
                'image' => 'https://picsum.photos/seed/wisata-anak/200/200.jpg'
            ],
            [
                'name' => 'Fotografi',
                'slug' => 'fotografi',
                'description' => 'Spot foto terbaik dan tips fotografi travel',
                'image' => 'https://picsum.photos/seed/fotografi/200/200.jpg'
            ],
            [
                'name' => 'Musim & Festival',
                'slug' => 'musim-festival',
                'description' => 'Panduan festival dan event musiman',
                'image' => 'https://picsum.photos/seed/musim-festival/200/200.jpg'
            ],
            [
                'name' => 'Kesehatan & Keamanan',
                'slug' => 'kesehatan-keamanan',
                'description' => 'Tips kesehatan dan keamanan saat traveling',
                'image' => 'https://picsum.photos/seed/kesehatan-keamanan/200/200.jpg'
            ],
            [
                'name' => 'Digital Nomad',
                'slug' => 'digital-nomad',
                'description' => 'Panduan untuk bekerja sambil traveling',
                'image' => 'https://picsum.photos/seed/digital-nomad/200/200.jpg'
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
