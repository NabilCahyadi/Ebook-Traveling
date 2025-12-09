<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CollectionEbookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil ID koleksi berdasarkan slug agar lebih robust
        $bestSellersCollection = DB::table('collections')->where('slug', 'best-sellers')->first();
        $featuredCollection = DB::table('collections')->where('slug', 'featured-collection')->first();

        if (!$bestSellersCollection || !$featuredCollection) {
            $this->command->warn('Tidak menemukan koleksi "Best Sellers" atau "Featured Collection". Jalankan CollectionSeeder terlebih dahulu!');
            return;
        }

        // --- Definisikan e-book untuk setiap koleksi ---

        // E-book untuk "Best Sellers" (dipilih berdasarkan read_count dan total_reviews tinggi)
        $bestSellersEbookIds = [
            'ab450e38-cf2e-11f0-9073-745d2258e25c', // Laskar Pelangi
            'ab4503f6-cf2e-11f0-9073-745d2258e25c', // Sapiens
            'ab44d6ec-cf2e-11f0-9073-745d2258e25c', // The Subtle Art of Not Giving a F*ck
            'ab44d460-cf2e-11f0-9073-745d2258e25c', // How to Win Friends and Influence People
            '44f9495b-cee0-11f0-b8a8-745d2258e25c', // Atomic Habits
            'ab44ce24-cf2e-11f0-9073-745d2258e25c', // Rich Dad Poor Dad
        ];

        // E-book untuk "Featured Collection" (pilihan editor, campuran buku is_featured dan klasik)
        $featuredEbookIds = [
            '44f72995-cee0-11f0-b8a8-745d2258e25c', // Clean Code
            '44f9495b-cee0-11f0-b8a8-745d2258e25c', // Atomic Habits (bisa ada di dua koleksi)
            '44f94d4f-cee0-11f0-b8a8-745d2258e25c', // The Pragmatic Programmer
            '44f95374-cee0-11f0-b8a8-745d2258e25c', // Laut Bercerita
            '44f96c10-cee0-11f0-b8a8-745d2258e25c', // The Design of Everyday Things
            'ab44fe95-cf2e-11f0-9073-745d2258e25c', // Introduction to Algorithms
            'ab44bf32-cf2e-11f0-9073-745d2258e25c', // 1984
        ];

        // Siapkan data untuk di-insert
        $dataToInsert = [];

        // Proses Best Sellers
        foreach ($bestSellersEbookIds as $ebookId) {
            $dataToInsert[] = [
                'id'             => Str::uuid(),
                'collection_id'  => $bestSellersCollection->id,
                'ebook_id'       => $ebookId,
                'created_at'     => now(),
            ];
        }

        // Proses Featured Collection
        foreach ($featuredEbookIds as $ebookId) {
            $dataToInsert[] = [
                'id'             => Str::uuid(),
                'collection_id'  => $featuredCollection->id,
                'ebook_id'       => $ebookId,
                'created_at'     => now(),
            ];
        }

        // Masukkan ke tabel pivot `collection_ebook`
        DB::table('collection_ebooks')->insert($dataToInsert);

        $this->command->info('Berhasil menghubungkan ' . count($dataToInsert) . ' e-book ke koleksi.');
    }
}
