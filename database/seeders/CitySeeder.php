<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cities = [
            // Pulau Jawa
            ['name' => 'Jakarta', 'province' => 'DKI Jakarta', 'country' => 'Indonesia', 'is_popular' => true, 'order_index' => 1],
            ['name' => 'Bandung', 'province' => 'Jawa Barat', 'country' => 'Indonesia', 'is_popular' => true, 'order_index' => 2],
            ['name' => 'Surabaya', 'province' => 'Jawa Timur', 'country' => 'Indonesia', 'is_popular' => true, 'order_index' => 3],
            ['name' => 'Yogyakarta', 'province' => 'DI Yogyakarta', 'country' => 'Indonesia', 'is_popular' => true, 'order_index' => 4],
            ['name' => 'Semarang', 'province' => 'Jawa Tengah', 'country' => 'Indonesia', 'is_popular' => true, 'order_index' => 5],
            ['name' => 'Malang', 'province' => 'Jawa Timur', 'country' => 'Indonesia', 'is_popular' => true, 'order_index' => 6],
            ['name' => 'Solo', 'province' => 'Jawa Tengah', 'country' => 'Indonesia', 'is_popular' => true, 'order_index' => 7],
            ['name' => 'Bogor', 'province' => 'Jawa Barat', 'country' => 'Indonesia', 'is_popular' => true, 'order_index' => 8],
            ['name' => 'Depok', 'province' => 'Jawa Barat', 'country' => 'Indonesia', 'is_popular' => false, 'order_index' => 9],
            ['name' => 'Tangerang', 'province' => 'Banten', 'country' => 'Indonesia', 'is_popular' => false, 'order_index' => 10],
            ['name' => 'Bekasi', 'province' => 'Jawa Barat', 'country' => 'Indonesia', 'is_popular' => false, 'order_index' => 11],

            // Pulau Sumatera
            ['name' => 'Medan', 'province' => 'Sumatera Utara', 'country' => 'Indonesia', 'is_popular' => true, 'order_index' => 12],
            ['name' => 'Palembang', 'province' => 'Sumatera Selatan', 'country' => 'Indonesia', 'is_popular' => true, 'order_index' => 13],
            ['name' => 'Padang', 'province' => 'Sumatera Barat', 'country' => 'Indonesia', 'is_popular' => false, 'order_index' => 14],
            ['name' => 'Pekanbaru', 'province' => 'Riau', 'country' => 'Indonesia', 'is_popular' => false, 'order_index' => 15],
            ['name' => 'Batam', 'province' => 'Kepulauan Riau', 'country' => 'Indonesia', 'is_popular' => false, 'order_index' => 16],
            ['name' => 'Bandar Lampung', 'province' => 'Lampung', 'country' => 'Indonesia', 'is_popular' => false, 'order_index' => 17],
            ['name' => 'Jambi', 'province' => 'Jambi', 'country' => 'Indonesia', 'is_popular' => false, 'order_index' => 18],
            ['name' => 'Bengkulu', 'province' => 'Bengkulu', 'country' => 'Indonesia', 'is_popular' => false, 'order_index' => 19],

            // Kalimantan
            ['name' => 'Banjarmasin', 'province' => 'Kalimantan Selatan', 'country' => 'Indonesia', 'is_popular' => false, 'order_index' => 20],
            ['name' => 'Balikpapan', 'province' => 'Kalimantan Timur', 'country' => 'Indonesia', 'is_popular' => false, 'order_index' => 21],
            ['name' => 'Pontianak', 'province' => 'Kalimantan Barat', 'country' => 'Indonesia', 'is_popular' => false, 'order_index' => 22],
            ['name' => 'Samarinda', 'province' => 'Kalimantan Timur', 'country' => 'Indonesia', 'is_popular' => false, 'order_index' => 23],
            ['name' => 'Palangkaraya', 'province' => 'Kalimantan Tengah', 'country' => 'Indonesia', 'is_popular' => false, 'order_index' => 24],

            // Sulawesi
            ['name' => 'Makassar', 'province' => 'Sulawesi Selatan', 'country' => 'Indonesia', 'is_popular' => false, 'order_index' => 25],
            ['name' => 'Manado', 'province' => 'Sulawesi Utara', 'country' => 'Indonesia', 'is_popular' => false, 'order_index' => 26],
            ['name' => 'Palu', 'province' => 'Sulawesi Tengah', 'country' => 'Indonesia', 'is_popular' => false, 'order_index' => 27],
            ['name' => 'Kendari', 'province' => 'Sulawesi Tenggara', 'country' => 'Indonesia', 'is_popular' => false, 'order_index' => 28],
            ['name' => 'Gorontalo', 'province' => 'Gorontalo', 'country' => 'Indonesia', 'is_popular' => false, 'order_index' => 29],

            // Bali & Nusa Tenggara
            ['name' => 'Denpasar', 'province' => 'Bali', 'country' => 'Indonesia', 'is_popular' => true, 'order_index' => 30],
            ['name' => 'Mataram', 'province' => 'Nusa Tenggara Barat', 'country' => 'Indonesia', 'is_popular' => false, 'order_index' => 31],
            ['name' => 'Kupang', 'province' => 'Nusa Tenggara Timur', 'country' => 'Indonesia', 'is_popular' => false, 'order_index' => 32],

            // Papua & Maluku
            ['name' => 'Jayapura', 'province' => 'Papua', 'country' => 'Indonesia', 'is_popular' => false, 'order_index' => 33],
            ['name' => 'Ambon', 'province' => 'Maluku', 'country' => 'Indonesia', 'is_popular' => false, 'order_index' => 34],
            ['name' => 'Ternate', 'province' => 'Maluku Utara', 'country' => 'Indonesia', 'is_popular' => false, 'order_index' => 35],
        ];

        foreach ($cities as $cityData) {
            City::create([
                'id' => Str::uuid(),
                'name' => $cityData['name'],
                'slug' => Str::slug($cityData['name']),
                'province' => $cityData['province'],
                'country' => $cityData['country'],
                'is_popular' => $cityData['is_popular'],
                'is_active' => true,
                'order_index' => $cityData['order_index'],
                'views_count' => 0,
            ]);
        }

        $this->command->info('✅ Cities seeded successfully!');
        $this->command->info('📍 Total: ' . count($cities) . ' cities created');
    }
}
