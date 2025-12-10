<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class EbookForCollectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $creatorId = DB::table('users')->where('email', 'creator1@ebook.com')->value('id'); // Contoh creator
        $categoryId = DB::table('categories')->first()?->id; // Contoh kategori
        $cityId = DB::table('cities')->first()?->id; // Contoh kota

        $ebooks = [];

        // --- 6 Buku untuk "Best Seller" ---
        for ($i = 1; $i <= 6; $i++) {
            $ebooks[] = [
                'id' => (string) Str::uuid(),
                'title' => "[BS] The Ultimate Guide to Success Vol. {$i}",
                'slug' => "the-ultimate-guide-to-success-vol-{$i}-" . Str::random(5),
                'description' => "Buku ke-{$i} dari seri panduan sukses terlaris kami. Wajib dibaca untuk mencapai puncak karir.",
                'short_description' => "Panduan sukses best seller volume {$i}.",
                'author' => "Success Guru {$i}",
                'cover_image' => "images/covers/bestseller-{$i}.webp",
                'pdf_file' => "pdfs/bestseller-{$i}.pdf",
                'language' => 'en',
                'status' => 'published',
                'average_rating' => rand(45, 50) / 10,
                'total_reviews' => rand(100, 500),
                'view_count' => rand(5000, 15000),
                'read_count' => rand(1000, 5000),
                'creator_id' => $creatorId,
                'category_id' => $categoryId,
                'city_id' => $cityId,
                'published_at' => now()->subDays(rand(30, 90)),
                'created_at' => now()->subDays(rand(31, 91)),
                'updated_at' => now(),
            ];
        }

        // --- 7 Buku untuk "Featured Collection" ---
        for ($i = 1; $i <= 7; $i++) {
            $ebooks[] = [
                'id' => (string) Str::uuid(),
                'title' => "[FC] The Art of Modern Thinking Part {$i}",
                'slug' => "the-art-of-modern-thinking-part-{$i}-" . Str::random(5),
                'description' => "Eksplorasi mendalam tentang cara berpikir modern di era digital, bagian ke-{$i}.",
                'short_description' => "Buku pilihan tentang seni berpikir modern.",
                'author' => "Modern Thinker {$i}",
                'cover_image' => "images/covers/featured-{$i}.webp",
                'pdf_file' => "pdfs/featured-{$i}.pdf",
                'language' => 'en',
                'status' => 'published',
                'average_rating' => rand(42, 48) / 10,
                'total_reviews' => rand(80, 300),
                'view_count' => rand(3000, 12000),
                'read_count' => rand(800, 3000),
                'creator_id' => $creatorId,
                'category_id' => $categoryId,
                'city_id' => $cityId,
                'published_at' => now()->subDays(rand(15, 60)),
                'created_at' => now()->subDays(rand(16, 61)),
                'updated_at' => now(),
            ];
        }

        // --- 8 Buku untuk "Latest" ---
        for ($i = 1; $i <= 8; $i++) {
            $ebooks[] = [
                'id' => (string) Str::uuid(),
                'title' => "[LT] Fresh Perspectives on Technology {$i}",
                'slug' => "fresh-perspectives-on-technology-{$i}-" . Str::random(5),
                'description' => "Buku terbaru yang membahas perkembangan teknologi terkini dari perspektif yang segar, edisi ke-{$i}.",
                'short_description' => "Buku baru tentang perspektif teknologi.",
                'author' => "Tech Author {$i}",
                'cover_image' => "images/covers/latest-{$i}.webp",
                'pdf_file' => "pdfs/latest-{$i}.pdf",
                'language' => 'en',
                'status' => 'published',
                'average_rating' => rand(40, 47) / 10,
                'total_reviews' => rand(10, 100),
                'view_count' => rand(500, 4000),
                'read_count' => rand(100, 1500),
                'creator_id' => $creatorId,
                'category_id' => $categoryId,
                'city_id' => $cityId,
                'published_at' => now()->subDays(rand(1, 14)),
                'created_at' => now()->subDays(rand(2, 15)),
                'updated_at' => now(),
            ];
        }

        DB::table('ebooks')->insert($ebooks);
    }
}
