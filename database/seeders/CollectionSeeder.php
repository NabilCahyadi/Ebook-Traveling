<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CollectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $collections = [
            [
                'id' => '3fd54895-cf23-11f0-9073-745d2258e25c',
                'name' => 'Best Sellers',
                'slug' => 'best-sellers',
                'description' => 'Buku-buku terlaris pilihan pembaca',
                'order_index' => 2,
                'is_active' => 1,
                'show_in_homepage' => 1,
                'created_at' => Carbon::create(2025, 12, 2, 9, 4, 34),
                'updated_at' => Carbon::create(2025, 12, 2, 9, 4, 34),
            ],
            [
                'id' => '3fd5579a-cf23-11f0-9073-745d2258e25c',
                'name' => 'Featured Collection',
                'slug' => 'featured-collection',
                'description' => 'Koleksi pilihan editor bulan ini',
                'order_index' => 8,
                'is_active' => 1,
                'show_in_homepage' => 1,
                'created_at' => Carbon::create(2025, 12, 2, 9, 4, 34),
                'updated_at' => Carbon::create(2025, 12, 2, 9, 4, 34),
            ],
        ];

        // Menggunakan insertOrIgnore untuk mencegah error duplikat jika dijalankan ulang
        DB::table('collections')->insertOrIgnore($collections);

        $this->command->info('Berhasil menambahkan ' . count($collections) . ' koleksi.');
    }
}
