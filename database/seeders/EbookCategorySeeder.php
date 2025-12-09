<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class EbookCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Daftar ID e-book yang Anda berikan
        $ebookIds = [
            '44f929d0-cee0-11f0-b8a8-745d2258e25c',
            '44f95087-cee0-11f0-b8a8-745d2258e25c',
            '44f95637-cee0-11f0-b8a8-745d2258e25c',
            '44f96603-cee0-11f0-b8a8-745d2258e25c',
            '44f96951-cee0-11f0-b8a8-745d2258e25c',
            'ab44ac4f-cf2e-11f0-9073-745d2258e25c',
            'ab44b872-cf2e-11f0-9073-745d2258e25c',
            'ab44bf32-cf2e-11f0-9073-745d2258e25c',
            'ab44c4df-cf2e-11f0-9073-745d2258e25c',
            'ab44c748-cf2e-11f0-9073-745d2258e25c',
            'ab44d0f6-cf2e-11f0-9073-745d2258e25c',
            'ab44d460-cf2e-11f0-9073-745d2258e25c',
            'ab44d97e-cf2e-11f0-9073-745d2258e25c',
            'ab44faf6-cf2e-11f0-9073-745d2258e25c',
            'ab450121-cf2e-11f0-9073-745d2258e25c',
            'ab45069e-cf2e-11f0-9073-745d2258e25c',
            'ab450945-cf2e-11f0-9073-745d2258e25c',
            'ab4513ef-cf2e-11f0-9073-745d2258e25c',
            'ab4516f0-cf2e-11f0-9073-745d2258e25c',
            '44f72995-cee0-11f0-b8a8-745d2258e25c',
            '44f9495b-cee0-11f0-b8a8-745d2258e25c',
            '44f94d4f-cee0-11f0-b8a8-745d2258e25c',
            '44f95374-cee0-11f0-b8a8-745d2258e25c',
            '44f96c10-cee0-11f0-b8a8-745d2258e25c',
            'ab38443d-cf2e-11f0-9073-745d2258e25c',
            'ab44b4bc-cf2e-11f0-9073-745d2258e25c',
            'ab44bb0c-cf2e-11f0-9073-745d2258e25c',
            'ab44c21c-cf2e-11f0-9073-745d2258e25c',
            'ab44c9d3-cf2e-11f0-9073-745d2258e25c',
            'ab44ce24-cf2e-11f0-9073-745d2258e25c',
            'ab44d6ec-cf2e-11f0-9073-745d2258e25c',
            'ab44fe95-cf2e-11f0-9073-745d2258e25c',
            'ab4503f6-cf2e-11f0-9073-745d2258e25c',
            'ab450bba-cf2e-11f0-9073-745d2258e25c',
            'ab450e38-cf2e-11f0-9073-745d2258e25c',
        ];

        // Ambil semua ID kategori yang namanya adalah nama kota (sesuai seeder sebelumnya)
        $cityCategoryIds = DB::table('categories')
            ->whereIn('name', [
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
                'Samarinda'
            ])
            ->pluck('id'); // Hanya ambil kolom 'id'

        // Cek apakah kategori kota sudah ada
        if ($cityCategoryIds->isEmpty()) {
            $this->command->warn('Tidak menemukan kategori kota. Jalankan CityCategorySeeder terlebih dahulu!');
            return;
        }

        $dataToInsert = [];
        foreach ($ebookIds as $ebookId) {
            // Pilih satu ID kategori secara acak untuk setiap e-book
            $randomCategoryId = $cityCategoryIds->random();

            $dataToInsert[] = [
                'id'           => Str::uuid(), // <-- TAMBAHKAN BARIS INI
                'ebook_id'    => $ebookId,
                'category_id' => $randomCategoryId,
                'created_at'  => now(),
            ];
        }

        // Masukkan semua data ke tabel pivot `ebook_categories`
        DB::table('ebook_categories')->insert($dataToInsert);

        $this->command->info('Berhasil menghubungkan ' . count($dataToInsert) . ' e-book ke kategori kota.');
    }
}
