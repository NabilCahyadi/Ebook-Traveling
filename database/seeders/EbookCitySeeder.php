<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Ebook;

class EbookCitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil semua ID kota yang sudah ada
        $cityIds = \App\Models\City::pluck('id')->toArray();

        if (empty($cityIds)) {
            $this->command->error('⚠️ Tidak bisa menjalankan EbookCitySeeder. Pastikan CitySeeder sudah dijalankan.');
            return;
        }

        // Update ebook yang belum memiliki city_id
        $ebooksWithoutCity = Ebook::whereNull('city_id')->get();

        if ($ebooksWithoutCity->isEmpty()) {
            $this->command->info('✅ Semua ebook sudah memiliki kota.');
            return;
        }

        $updatedCount = 0;

        foreach ($ebooksWithoutCity as $ebook) {
            // Pilih satu ID kota secara acak
            $randomCityId = $cityIds[array_rand($cityIds)];

            // Update city_id untuk ebook ini
            $ebook->update(['city_id' => $randomCityId]);
            $updatedCount++;
        }

        $this->command->info("✅ Berhasil menghubungkan {$updatedCount} ebook ke kota secara acak.");
    }
}
