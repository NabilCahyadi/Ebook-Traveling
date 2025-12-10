<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Collection;
use App\Models\Ebook;

class CollectionEbookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil ID koleksi berdasarkan slug agar lebih robust
        $bestSellersCollection = Collection::where('slug', 'best-seller')->first();
        $featuredCollection = Collection::where('slug', 'featured-collection')->first();
        $latestCollection = Collection::where('slug', 'latest')->first();

        if (!$bestSellersCollection || !$featuredCollection || !$latestCollection) {
            $this->command->error('Tidak menemukan koleksi. Jalankan CollectionSeeder terlebih dahulu!');
            return;
        }

        // --- Definisikan e-book untuk setiap koleksi secara DINAMIS ---

        // 8 buku untuk "Best Seller" (dipilih berdasarkan read_count tertinggi)
        $bestSellerEbooks = Ebook::orderBy('read_count', 'desc')->take(8)->pluck('id');

        // 10 buku untuk "Featured Collection" (dipilih secara acak dari buku dengan rating tinggi)
        $featuredEbooks = Ebook::where('average_rating', '>=', 4.7)->inRandomOrder()->take(10)->pluck('id');

        // 7 buku untuk "Latest" (dipilih berdasarkan published_at terbaru)
        $latestEbooks = Ebook::orderBy('published_at', 'desc')->take(7)->pluck('id');

        // Siapkan data untuk di-insert ke tabel pivot `collection_ebook`
        $dataToInsert = [];

        // Proses Best Sellers
        foreach ($bestSellerEbooks as $index => $ebookId) {
            $dataToInsert[] = [
                'id' => (string) Str::uuid(),
                'collection_id' => $bestSellersCollection->id,
                'ebook_id' => $ebookId,
                'order_index' => $index,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Proses Featured Collection
        foreach ($featuredEbooks as $index => $ebookId) {
            $dataToInsert[] = [
                'id' => (string) Str::uuid(),
                'collection_id' => $featuredCollection->id,
                'ebook_id' => $ebookId,
                'order_index' => $index,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Proses Latest
        foreach ($latestEbooks as $index => $ebookId) {
            $dataToInsert[] = [
                'id' => (string) Str::uuid(),
                'collection_id' => $latestCollection->id,
                'ebook_id' => $ebookId,
                'order_index' => $index,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Masukkan ke tabel pivot
        DB::table('collection_ebook')->insert($dataToInsert);

        $this->command->info('Berhasil menghubungkan ' . count($dataToInsert) . ' e-book ke koleksi.');
    }
}
