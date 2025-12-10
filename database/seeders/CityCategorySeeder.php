<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CityCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $capitalCities = [
            'Jakarta',
            'Surabaya',
            'Bandung',
            'Medan',
            'Semarang',
            'Makassar',
            'Palembang',
            'Tangerang',
            'Depok',
            'Batam',
            'Bogor',
            'Pekanbaru',
            'Bandar Lampung',
            'Malang',
            'Samarinda',
            // Tambahkan ibu kota provinsi lainnya sesuai kebutuhan
        ];

        foreach ($capitalCities as $cityName) {
            DB::table('categories')->insert([
                'id' => Str::uuid(),
                'name' => $cityName,
                'slug' => Str::slug($cityName),
                'description' => "Koleksi e-book tentang perjalanan dan panduan wisata di kota {$cityName}.",
                'image' => "https://example.com/images/categories/{$cityName}.jpg", // Ganti dengan URL gambar yang sesuai
                'type' => 'city', // Beri tipe khusus 'city' agar mudah dibedakan
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
