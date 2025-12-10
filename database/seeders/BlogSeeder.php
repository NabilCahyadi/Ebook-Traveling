<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Blog;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\Ebook;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
     function run(): void
    {
        // Ambil user yang bisa menjadi author (admin dan creator)
        $authors = User::whereHas('roles', function ($query) {
            $query->whereIn('name', ['admin', 'creator']);
        })->pluck('id')->toArray();

        // Ambil ID dari beberapa e-book yang sudah dipublish
        $ebookIds = Ebook::where('status', 'published')->pluck('id')->toArray();

        if (empty($authors) || empty($ebookIds)) {
            $this->command->error('Tidak ada author atau e-book yang ditemukan. Jalankan UserSeeder dan EbookSeeder terlebih dahulu!');
            return;
        }

        // --- 10 Artikel Blog Spesifik ---
        $blogs = [
            [
                'title' => 'Menjelajahi Keajaiban Raja Ampat: Surga Tersembunyi di Timur Indonesia',
                'excerpt' => 'Raja Ampat bukan sekadar destinasi, itu adalah sebuah pengalaman spiritual. Temukan kekayaan bawah lautnya yang memukau dan pemandangan dari atas bukit yang akan mencuri napas Anda.',
                'content' => 'Terletak di ujung barat Papua, Raja Ampat adalah sebuah kepulauan yang menjadi surga bagi penyelam dan pecinta alam. Dengan lebih dari 75% spesies karang dunia dan 1.500 spesies ikan, kawasan ini menawarkan pengalaman bawah laut yang tak tertandingi. Artikel ini akan membawa Anda menyusuri Wayag, Piaynemo, dan spot-spot tersembunyi lainnya.',
                'status' => 'published',
                'category' => 'Travel',
                'tags' => json_encode(['travel', 'raja-ampat', 'papua', 'diving', 'indonesia']),
                'featured_image' => '/images/blogs/1.webp',
            ],
            [
                'title' => 'Tips dan Trik Fotografi Landscape untuk Pemula',
                'excerpt' => 'Ingin menghasilkan foto landscape yang Instagramable? Mulai dari memilih waktu hingga komposisi, simak panduan lengkapnya di sini.',
                'content' => 'Fotografi landscape adalah seni menangkap keindahan alam. Untuk pemula, memulainya bisa terasa membingungkan. Kami akan membagikan tips dasar seperti pentingnya "Golden Hour", aturan komposisi sepertiga (rule of thirds), dan perlengkapan minimal yang harus Anda bawa untuk mendapatkan foto yang memukau.',
                'status' => 'published',
                'category' => 'Tips & Trick',
                'tags' => json_encode(['fotografi', 'landscape', 'tips', 'pemula', 'kamera']),
                'featured_image' => '/images/blogs/2.webp',
            ],
            [
                'title' => 'Kuliner Nusantara: 5 Makanan Pedas yang Wajib Dicoba',
                'excerpt' => 'Bagi Anda pecinta makanan pedas, Indonesia adalah surga. Ini dia 5 makanan pedas legendaris dari berbagai penjuru negeri yang siap menggoyang lidah Anda.',
                'content' => 'Dari cabai rawit hijau khas Padang hingga sambal terasi ala Jawa Timur, kekayaan rasa pedas di Indonesia sangat beragam. Artikel ini mengulas 5 hidangan pedas yang wajib ada dalam daftar kuliner Anda, seperti Ayam Penyet Rica-rica, Seblak Bandung, dan Ceker Setan.',
                'status' => 'published',
                'category' => 'Food & Culture',
                'tags' => json_encode(['kuliner', 'makanan-pedas', 'indonesia', 'food', 'travel']),
                'featured_image' => '/images/blogs/3.webp',
            ],
            [
                'title' => 'Misteri Candi Borobudur: Kisah di Balik Reliefnya',
                'excerpt' => 'Borobudur lebih dari sekadar tumpukan batu. Setiap relief menceritakan sebuah kisah. Mari kita gali lebih dalam makna filosofis yang tersimpan di dalamnya.',
                'content' => 'Sebagai salah satu situs warisan dunia, Candi Borobudur menyimpan ribuan cerita dalam reliefnya. Dari kisah Karmawibhangga hingga perjalanan Sang Buddha, setiap panel adalah sebuah jendela menuju peradaban masa lalu. Kami akan mengajak Anda memahami simbolisme dan filosofi di balik ukiran yang megah ini.',
                'status' => 'published',
                'category' => 'Culture & History',
                'tags' => json_encode(['borobudur', 'sejarah', 'budaya', 'yogyakarta', 'heritage']),
                'featured_image' => '/images/blogs/4.webp',
            ],
            [
                'title' => 'Panduan Lengkap Mendaki Gunung Rinjani untuk Pertama Kali',
                'excerpt' => 'Mendaki Rinjani adalah sebuah tantangan. Bagi Anda yang pertama kali, panduan ini akan mempersiapkan Anda dari awal hingga akhir petualangan.',
                'content' => 'Gunung Rinjani di Lombok menawarkan lebih dari sekadar puncak. Danau Segara Anak yang indah, pemandangan matahari terbit, dan sensasi berada di ketinggian adalah impiannya. Artikel ini memberikan panduan rute, persiapan fisik, perlengkapan wajib, dan tips keselamatan selama pendakian.',
                'status' => 'draft',
                'category' => 'Travel & Adventure',
                'tags' => json_encode(['rinjani', 'pendakian', 'lombok', 'adventure', 'gunung']),
                'featured_image' => '/images/blogs/5.webp',
            ],
            [
                'title' => 'Review Aplikasi Travel Terbaik yang Wajib Ada di Smartphone-mu',
                'excerpt' => 'Dari mencari tiket pesawat murah hingga menemukan penginapan unik, 5 aplikasi ini akan menjadi sahabat setia perjalanan Anda.',
                'content' => 'Di era digital, merencanakan perjalanan menjadi jauh lebih mudah. Kami telah merangkum 5 aplikasi travel terbaik yang bisa membantu Anda, seperti Skyscanner untuk tiket, Airbnb untuk akomodasi, dan Maps.me untuk navigasi offline. Simak review lengkap dan keunggulan masing-masing.',
                'status' => 'published',
                'category' => 'Review & Tech',
                'tags' => json_encode(['aplikasi', 'travel', 'review', 'smartphone', 'teknologi']),
                'featured_image' => '/images/blogs/6.webp',
            ],
            [
                'title' => 'Sejarah Kerajaan Majapahit: Kejayaan di Ujung Tenggara',
                'excerpt' => 'Majapahit adalah salah satu kerajaan maritim terbesar di Asia Tenggara. Mari kita telusuri jejak kejayaan dan warisan yang ditinggalkannya.',
                'content' => 'Pada puncak kejayaannya di abad ke-14, Majapahit menguasai wilayah yang luas, mulai dari Indonesia hingga Malaysia dan Filipina. Artikel ini akan mengupas sejarah berdirinya kerajaan ini, tokoh-tokoh penting seperti Gajah Mada, dan peninggalan sejarah yang bisa kita lihat hari ini.',
                'status' => 'published',
                'category' => 'Culture & History',
                'tags' => json_encode(['majapahit', 'sejarah-indonesia', 'kerajaan', 'nusantara', 'heritage']),
                'featured_image' => '/images/blogs/7.webp',
            ],
            [
                'title' => 'Cara Menemukan Tiket Pesawat Murah: Rahasia yang Jarang Diketahui',
                'excerpt' => 'Jangan bayar lebih mahal untuk tiket pesawat! Pelajari trik dan waktu yang tepat untuk mendapatkan harga terbaik untuk perjalanan Anda.',
                'content' => 'Harga tiket pesawat bisa berfluktuasi secara drastis. Tapi jangan khawatir, ada beberapa trik yang bisa Anda lakukan. Kami akan membagikan rahasia seperti menggunakan fitur incognito, membeli tiket pada hari tertentu, dan memanfaatkan transit untuk mendapatkan harga yang jauh lebih murah.',
                'status' => 'published',
                'category' => 'Tips & Trick',
                'tags' => json_encode(['tiket-pesawat', 'tips-travel', 'hemat', 'penerbangan', 'travel']),
                'featured_image' => '/images/blogs/8.webp',
            ],
            [
                'title' => 'Menyelami Keindahan Bawah Laut Taman Nasional Bunaken',
                'excerpt' => 'Bunaken adalah surga bagi penyelam. Terumbu karangnya yang masih terjaga dan biota lautnya yang beragam menawarkan pengalaman tak terlupakan.',
                'content' => 'Terletak di Sulawesi Utara, Taman Nasional Bunaken memiliki dinding bawah laut (drop-off) yang spektakuler. Anda bisa bertemu dengan ikan-ikan warna-warni, penyu hijau, dan bahkan hiu karang yang jinak. Artikel ini adalah panduan Anda untuk menjelajahi spot-spot diving terbaik di sana.',
                'status' => 'published',
                'category' => 'Travel & Nature',
                'tags' => json_encode(['bunaken', 'diving', 'sulawesi-utara', 'alam', 'snorkeling']),
                'featured_image' => '/images/blogs/9.webp',
            ],
            [
                'title' => 'Mengenal Lebih Dekat Seni Tari Tradisional Bali',
                'excerpt' => 'Bali tidak hanya indah, tapi juga kaya akan seni dan budaya. Salah satunya adalah tari tradisional yang penuh makna dan filosofi.',
                'content' => 'Tari Kecak, Tari Barong, dan Tari Legong adalah beberapa contoh seni tari Bali yang terkenal. Setiap tarian menceritakan sebuah kisah, baik itu dari epos Ramayana atau cerita rakyat lokal. Mari kita pelajari sejarah, kostum, dan makna di balik gerakan-gerakan yang anggun tersebut.',
                'status' => 'published',
                'category' => 'Culture & Art',
                'tags' => json_encode(['bali', 'tari-tradisional', 'seni', 'budaya', 'indonesia']),
                'featured_image' => '/images/blogs/10.webp',
            ],
        ];

        $blogsToInsert = [];
        $blogEbookPivotToInsert = [];

        foreach ($blogs as $index => $blogData) {
            $blogId = Str::uuid();
            $publishedAt = $blogData['status'] === 'published' ? now()->subDays(rand(1, 90)) : null;

            // Gunakan featured_image dari array, jika tidak ada gunakan default
            $featuredImage = $blogData['featured_image'] ?? 'https://via.placeholder.com/800x500.png?text=' . urlencode($blogData['title']);

            $blogsToInsert[] = [
                'id' => $blogId,
                'title' => $blogData['title'],
                'slug' => Str::slug($blogData['title']),
                'excerpt' => $blogData['excerpt'],
                'content' => $blogData['content'],
                'status' => $blogData['status'],
                'featured_image' => $featuredImage,
                'author_id' => $authors[array_rand($authors)],
                'category' => $blogData['category'],
                'tags' => $blogData['tags'],
                'published_at' => $publishedAt,
                'view_count' => rand(50, 5000),
                'meta_title' => $blogData['title'],
                'meta_description' => $blogData['excerpt'],
                'created_at' => $publishedAt ?? now(),
                'updated_at' => $publishedAt ?? now(),
            ];

            // Hubungkan blog dengan 1-4 e-book secara acak
            $numEbooksToLink = rand(1, 4);
            if ($numEbooksToLink > 0) {
                $randomEbookIds = array_rand($ebookIds, $numEbooksToLink);
                if (!is_array($randomEbookIds)) {
                    $randomEbookIds = [$randomEbookIds];
                }

                foreach ($randomEbookIds as $ebookIdIndex) {
                    $blogEbookPivotToInsert[] = [
                        'blog_id' => $blogId,
                        'ebook_id' => $ebookIds[$ebookIdIndex],
                    ];
                }
            }
        }

        DB::table('blogs')->insert($blogsToInsert);
        $this->command->info(count($blogsToInsert) . ' Blogs created successfully!');

        if (!empty($blogEbookPivotToInsert)) {
            DB::table('blog_ebook')->insert($blogEbookPivotToInsert);
            $this->command->info('Blog-Ebook relationships created successfully!');
        }
    }
}
