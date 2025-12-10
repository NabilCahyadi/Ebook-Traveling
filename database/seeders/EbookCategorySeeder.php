<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Ebook;
use App\Models\Category;

class EbookCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil semua ID ebook dan kategori yang sudah ada
        $ebookIds = Ebook::pluck('id')->toArray();
        $categoryIds = Category::pluck('id')->toArray();

        // Pastikan ada data ebook dan kategori
        if (empty($ebookIds) || empty($categoryIds)) {
            $this->command->warn('Tidak menemukan ebook atau kategori. Jalankan EbookSeeder dan CategorySeeder terlebih dahulu!');
            return;
        }

        $pivotData = [];

        foreach ($ebookIds as $ebookId) {
            // Hindari error jika jumlah kategori < 3
            $max = min(3, count($categoryIds));
            $num = rand(1, $max);

            // Dapatkan key acak (selalu dalam bentuk array)
            $keys = (array) array_rand($categoryIds, $num);

            foreach ($keys as $key) {
                $categoryId = $categoryIds[$key]; // Ambil value berdasarkan key

                $pivotData[] = [
                    'id' => (string) Str::uuid(),
                    'ebook_id' => $ebookId,
                    'category_id' => $categoryId,
                    'created_at' => now(),
                    // 'updated_at' => now(),
                ];
            }
        }

        // Masukkan semua data ke tabel pivot
        if (!empty($pivotData)) {
            DB::table('ebook_categories')->insert($pivotData);
            $this->command->info('Berhasil menghubungkan ' . count($pivotData) . ' ebook ke kategori.');
        } else {
            $this->command->warn('Tidak ada data kategori ebook yang bisa dibuat.');
        }
    }
}
