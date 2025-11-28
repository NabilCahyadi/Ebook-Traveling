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
            ['name' => 'Jakarta', 'province' => 'DKI Jakarta'],
            ['name' => 'Bandung', 'province' => 'Jawa Barat'],
            ['name' => 'Surabaya', 'province' => 'Jawa Timur'],
            ['name' => 'Yogyakarta', 'province' => 'DI Yogyakarta'],
            ['name' => 'Semarang', 'province' => 'Jawa Tengah'],
            ['name' => 'Malang', 'province' => 'Jawa Timur'],
            ['name' => 'Solo', 'province' => 'Jawa Tengah'],
            ['name' => 'Bogor', 'province' => 'Jawa Barat'],
            ['name' => 'Depok', 'province' => 'Jawa Barat'],
            ['name' => 'Tangerang', 'province' => 'Banten'],
            ['name' => 'Bekasi', 'province' => 'Jawa Barat'],

            // Pulau Sumatera
            ['name' => 'Medan', 'province' => 'Sumatera Utara'],
            ['name' => 'Palembang', 'province' => 'Sumatera Selatan'],
            ['name' => 'Padang', 'province' => 'Sumatera Barat'],
            ['name' => 'Pekanbaru', 'province' => 'Riau'],
            ['name' => 'Batam', 'province' => 'Kepulauan Riau'],
            ['name' => 'Bandar Lampung', 'province' => 'Lampung'],
            ['name' => 'Jambi', 'province' => 'Jambi'],
            ['name' => 'Bengkulu', 'province' => 'Bengkulu'],

            // Kalimantan
            ['name' => 'Banjarmasin', 'province' => 'Kalimantan Selatan'],
            ['name' => 'Balikpapan', 'province' => 'Kalimantan Timur'],
            ['name' => 'Pontianak', 'province' => 'Kalimantan Barat'],
            ['name' => 'Samarinda', 'province' => 'Kalimantan Timur'],
            ['name' => 'Palangkaraya', 'province' => 'Kalimantan Tengah'],

            // Sulawesi
            ['name' => 'Makassar', 'province' => 'Sulawesi Selatan'],
            ['name' => 'Manado', 'province' => 'Sulawesi Utara'],
            ['name' => 'Palu', 'province' => 'Sulawesi Tengah'],
            ['name' => 'Kendari', 'province' => 'Sulawesi Tenggara'],
            ['name' => 'Gorontalo', 'province' => 'Gorontalo'],

            // Bali & Nusa Tenggara
            ['name' => 'Denpasar', 'province' => 'Bali'],
            ['name' => 'Mataram', 'province' => 'Nusa Tenggara Barat'],
            ['name' => 'Kupang', 'province' => 'Nusa Tenggara Timur'],

            // Papua & Maluku
            ['name' => 'Jayapura', 'province' => 'Papua'],
            ['name' => 'Ambon', 'province' => 'Maluku'],
            ['name' => 'Ternate', 'province' => 'Maluku Utara'],
        ];

        foreach ($cities as $city) {
            City::create(array_merge(['id' => Str::uuid()], $city));
        }

        $this->command->info('✅ Cities seeded successfully!');
        $this->command->info('📍 Total: ' . count($cities) . ' cities created');
    }
}
