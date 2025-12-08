<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ID user yang akan menjadi author. GANTI dengan ID user yang valid di database Anda.
        $authorId = '019ad0b2-083b-7119-be43-3f8f78d0ec6f';

        $blogs = [
            [
                'title' => '10 Kesalahan Packing yang Paling Sering Dilakukan Pemula',
                'slug' => 'kesalahan-packing-pemula',
                'excerpt' => 'Jangan biarkan kesalahan packing merusak liburan Anda! Pelajari 10 kesalahan paling umum dan cara menghindarinya agar perjalanan Anda lebih lancar.',
                'content' => '<p>Packing adalah seni yang sering diremehkan. Banyak pemula yang melakukan kesalahan kecil yang berakibat besar, mulai dari barang tertinggal hingga koper yang terlalu berat. Artikel ini akan membahas 10 kesalahan paling umum saat packing, seperti membawa terlalu banyak pakaian, tidak menyiapkan barang penting di kabin, dan mengabaikan batasan maskapai. Dengan mengetahui kesalahan ini, Anda bisa mempersiapkan diri dengan lebih baik dan menikmati liburan tanpa stres.</p>',
                'featured_image' => 'images/blogs/blog-1.webp',
                'author_id' => $authorId,
                'category' => 'Tips Traveling',
                'tags' => json_encode(['Packing', 'Tips', 'Pemula']),
                'is_published' => 1,
                'published_at' => now()->subDays(5),
                'view_count' => 1520,
            ],
            [
                'title' => 'Mengenal Lebih Dekat Wisata Budaya Yogyakarta',
                'slug' => 'wisata-budaya-yogyakarta',
                'excerpt' => 'Yogyakarta bukan hanya tentang Malioboro. Jelajahi kekayaan budaya Jawa yang mendalam, dari keraton hingga candi-candi peninggalan sejarah.',
                'content' => '<p>Yogyakarta adalah kota yang memancarkan pesona budaya yang kuat. Tak heran jika kota ini sering disebut sebagai "Istimewa". Mulai dari Keraton Yogyakarta yang menjadi pusat kebudayaan Jawa, hingga keindahan Candi Borobudur dan Prambanan yang megah. Artikel ini akan mengajak Anda berkeliling Yogyakarta, menikmati tidak hanya keindahan alamnya, tetapi juga kedalamannya sejarah dan tradisi yang masih terjaga hingga kini.</p>',
                'featured_image' => 'images/blogs/blog-2.webp',
                'author_id' => $authorId,
                'category' => 'Destinasi',
                'tags' => json_encode(['Yogyakarta', 'Budaya', 'Candi']),
                'is_published' => 1,
                'published_at' => now()->subDays(12),
                'view_count' => 3450,
            ],
            [
                'title' => 'Panduan Lengkap Backpacker ke Raja Ampat',
                'slug' => 'panduan-backpacker-raja-ampat',
                'excerpt' => 'Siapkan tas gunung Anda! Ini adalah panduan lengkap untuk menjelajahi surga tersembunyi di Indonesia, Raja Ampat, dengan anggaran terbatas.',
                'content' => '<p>Raja Ampat adalah mimpi bagi setiap penyelam dan pecinta alam. Kekayaan bawah lautnya yang menakjubkan membuatnya sering disebut sebagai "The Last Paradise on Earth". Namun, menjelajahi Raja Ampat dengan budget terbatas (backpacking) membutuhkan persiapan ekstra. Panduan ini akan membahas mulai dari cara mencari tiket murah, transportasi lokal, penginapan budget, hingga spot-spot diving terbaik yang tidak boleh Anda lewatkan.</p>',
                'featured_image' => 'images/blogs/blog-3.webp',
                'author_id' => $authorId,
                'category' => 'Panduan Wisata',
                'tags' => json_encode(['Raja Ampat', 'Backpacking', 'Diving']),
                'is_published' => 1,
                'published_at' => now()->subDays(20),
                'view_count' => 5800,
            ],
            [
                'title' => 'Kuliner Khas Surabaya yang Wajib Anda Coba',
                'slug' => 'kuliner-khas-surabaya',
                'excerpt' => 'Surabaya, kota pahlawan, juga surganya kuliner. Dari Rawon hingga Rujak Cingur, inilah daftar makanan legendaris yang harus masuk dalam daftar kuliner Anda.',
                'content' => '<p>Berkunjung ke Surabaya tidak lengkap tanpa mencicipi kuliner khasnya. Kota ini menawarkan beragam hidangan lezat yang akan memanjakan lidah Anda. Mulai dari Rawon Setan yang terkenal, Lontong Balap yang gurih, hingga Rujak Cingur yang segar dan pedas. Jangan lupa juga untuk mencicipi Sate Klopo Ondomohen yang sudah melegenda. Artikel ini akan memandu Anda untuk menemukan warung-warung terbaik yang menyajikan hidangan ikonik kota Pahlawan ini.</p>',
                'featured_image' => 'images/blogs/blog-4.webp',
                'author_id' => $authorId,
                'category' => 'Kuliner',
                'tags' => json_encode(['Surabaya', 'Kuliner', 'Rawon']),
                'is_published' => 1,
                'published_at' => now()->subDays(1),
                'view_count' => 2100,
            ],
        ];

        // Generate UUID dan slug untuk setiap blog
        foreach ($blogs as &$blog) {
            $blog['id'] = Str::uuid();
            // Jika slug tidak ada, generate dari judul
            if (!isset($blog['slug'])) {
                $blog['slug'] = Str::slug($blog['title']);
            }
            $blog['created_at'] = now();
            $blog['updated_at'] = now();
        }

        // Masukkan data ke dalam tabel
        DB::table('blogs')->insert($blogs);
    }
}
