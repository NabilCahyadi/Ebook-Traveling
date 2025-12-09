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
            // Data lama
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
            // --- 5 DATA BLOG BARU ---
            [
                'title' => 'Liburan Seru Tanpa Bikin Kantong Bolong',
                'slug' => 'liburan-budget-minim',
                'excerpt' => 'Siapa bilang liburan harus mahal? Simak 7 tips jitu untuk menikmati perjalanan impian Anda tanpa harus menguras tabungan.',
                'content' => '<p>Liburan adalah hak semua orang, bukan hanya mereka yang punya budget besar. Dengan perencanaan yang matang, Anda bisa menjelajahi tempat-tempat indah tanpa harus khawatir soal keuangan. Artikel ini membagikan rahasia liburan hemat, mulai dari memanfaatkan promo tiket pesawat, memilih penginapan yang ramah di kantong, hingga cara cerdas mengatur alokasi dana selama perjalanan. Siap untuk petualangan tak terlupakan yang tetap terjangkau?</p>',
                'featured_image' => 'images/blogs/blog-5.webp',
                'author_id' => $authorId,
                'category' => 'Tips Traveling',
                'tags' => json_encode(['Budget', 'Tips', 'Hemat']),
                'is_published' => 1,
                'published_at' => now()->subDays(8),
                'view_count' => 4100,
            ],
            [
                'title' => 'Tips Fotografi Traveling Ala Influencer',
                'slug' => 'tips-fotografi-traveling',
                'excerpt' => 'Abadikan setiap momen perjalanan Anda seperti seorang profesional. Pelajari komposisi, lighting, dan editing ponsel untuk hasil foto yang Instagram-able.',
                'content' => '<p>Foto adalah kenangan abadi. Di era media sosial, kemampuan mengambil foto traveling yang bagus adalah sebuah keharusan. Anda tidak perlu kamera mahal untuk mendapatkan hasil yang memukau. Artikel ini akan mengajarkan Anda teknik-teknik dasar fotografi, seperti aturan sepertiga, memanfaatkan golden hour, hingga penggunaan aplikasi editing di ponsel untuk membuat foto Anda terlihat seperti hasil jepretan profesional.</p>',
                'featured_image' => 'images/blogs/blog-6.webp',
                'author_id' => $authorId,
                'category' => 'Tips Traveling',
                'tags' => json_encode(['Fotografi', 'Tips', 'Editing']),
                'is_published' => 1,
                'published_at' => now()->subDays(15),
                'view_count' => 6200,
            ],
            [
                'title' => 'Menemukan Surga Tersembunyi di Bali',
                'slug' => 'surga-tersembunyi-bali',
                'excerpt' => 'Selain Kuta dan Seminyak, Bali punya surga tersembunyi yang menenangkan. Yuk, jelajahi Nusa Penida, Munduk, dan destinasi lain yang masih perawan.',
                'content' => '<p>Bali memang tak ada matinya. Namun, di balik keramaian Kuta dan Seminyak, tersimpan pesona alam yang masih alami dan menenangkan. Pulau-pulau kecil seperti Nusa Penida dan Nusa Lembongan menawarkan pemandangan tebing yang dramatis dan air laut yang jernih. Sementara itu, daerah seperti Munduk dan Sidemen menawarkan pengalaman pedesaan yang autentik. Artikel ini akan menjadi panduan Anda untuk menjelajahi sisi lain dari Bali yang lebih tenang dan jauh dari hiruk pikuk.</p>',
                'featured_image' => 'images/blogs/blog-7.webp',
                'author_id' => $authorId,
                'category' => 'Destinasi',
                'tags' => json_encode(['Bali', 'Nusa Penida', 'Alam']),
                'is_published' => 1,
                'published_at' => now()->subDays(22),
                'view_count' => 7800,
            ],
            [
                'title' => 'Naik Angkot, Jelajahi Jakarta Seperti Lokal',
                'slug' => 'jelajahi-jakarta-angkot',
                'excerpt' => 'Lupakan aplikasi ojek online sesaat. Rasakan pengalaman otentik berkeliling Jakarta dengan naik angkot dan bus kota. Ini panduannya!',
                'content' => '<p>Berbeda dengan naik mobil pribadi, menggunakan angkutan umum seperti angkot dan bus TransJakarta memberikan Anda pengalaman yang jauh lebih otentik. Anda akan berdesak-desak dengan penumpang lain, menyaksikan kehidupan sehari-hari warga Jakarta, dan mungkin saja menemukan jalan pintas yang tidak ada di Google Maps. Meskipun terlihat menantang, artikel ini akan memberikan tips dan trik agar perjalanan Anda dengan angkot menjadi aman, nyaman, dan tentu saja, jauh lebih murah.</p>',
                'featured_image' => 'images/blogs/blog-8.webp',
                'author_id' => $authorId,
                'category' => 'Destinasi',
                'tags' => json_encode(['Jakarta', 'Angkot', 'Lokal']),
                'is_published' => 1,
                'published_at' => now()->subDays(3),
                'view_count' => 3200,
            ],
            [
                'title' => 'Jajanannya Bandung: Wisata Kuliner Ala Millennial',
                'slug' => 'wisata-kuliner-bandung',
                'excerpt' => 'Dari batagor hingga kopi susu, Bandung adalah surganya kuliner kekinian. Siapkan perut Anda dan ikuti kami berburu kuliner legendaris yang hits di media sosial.',
                'content' => '<p>Bandung selalu berhasil membuat wisatawan tergoda dengan berbagai macam kulinernya. Kota ini tidak hanya terkenal dengan makanan berat, tetapi juga jajanan pasar dan kafe yang Instagram-able. Mulai dari mencicipi Seblak yang pedas, mencari Baso Tahu yang gurih, hingga nongkrong di kedai kopi susu yang legendaris. Artikel ini adalah daftar wajib bagi para foodies yang ingin menjelajahi Bandung melalui perutnya.</p>',
                'featured_image' => 'images/blogs/blog-9.webp',
                'author_id' => $authorId,
                'category' => 'Kuliner',
                'tags' => json_encode(['Bandung', 'Kuliner', 'Jajan']),
                'is_published' => 1,
                'published_at' => now()->subDays(10),
                'view_count' => 5100,
            ],
        ];

        // Generate UUID dan timestamp untuk setiap blog
        foreach ($blogs as &$blog) {
            $blog['id'] = Str::uuid();
            $blog['created_at'] = now();
            $blog['updated_at'] = now();
        }

        // Masukkan data ke dalam tabel
        DB::table('blogs')->insert($blogs);

        $this->command->info('Berhasil menambahkan ' . count($blogs) . ' blog.');
    }
}
