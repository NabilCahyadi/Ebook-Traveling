<?php

namespace Database\Seeders;

<<<<<<< HEAD
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
=======
use Illuminate\Database\Seeder;
use App\Models\Blog;
use App\Models\User;
>>>>>>> development
use Illuminate\Support\Str;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
<<<<<<< HEAD
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
=======
        // Get admin user as author
        $admin = User::where('email', 'admin@ebook.com')
            ->orWhere('email', 'nabilcahyadi155@gmail.com')
            ->first();

        if (!$admin) {
            $admin = User::first();
        }

        if (!$admin) {
            $this->command->error('No users found. Please run UserSeeder first.');
            return;
        }

        $authorId = $admin->id;

        $blogs = [
            [
                'title' => 'Liburan Hemat Budget: Cara Menghemat Jutaan Rupiah Tanpa Mengorbankan Kenyamanan',
                'slug' => 'liburan-hemat-budget-' . Str::random(5),
                'excerpt' => 'Panduan lengkap untuk merencanakan liburan dengan budget terbatas namun tetap menyenangkan. Tips praktis dari para travel expert.',
                'content' => '<p>Traveling tidak harus mahal! Dengan perencanaan yang tepat, Anda bisa menikmati liburan impian tanpa menguras tabungan. Berikut adalah strategi terbaik untuk menghemat biaya perjalanan Anda.</p><h2>1. Pesan Tiket Jauh-Jauh Hari</h2><p>Booking tiket pesawat 2-3 bulan sebelum keberangkatan bisa menghemat hingga 50% biaya transportasi. Gunakan aplikasi pembanding harga untuk mendapatkan deal terbaik.</p><h2>2. Pilih Akomodasi Alternatif</h2><p>Hostel, guesthouse, atau homestay sering kali lebih murah dan menawarkan pengalaman lokal yang autentik. Pertimbangkan juga opsi seperti Airbnb atau house sitting.</p>',
                'category' => 'Budget Travel',
                'status' => 'published',
                'view_count' => rand(5000, 15000),
                'author_id' => $authorId,
                'published_at' => now()->subDays(60),
                'tags' => json_encode(['budget', 'tips', 'hemat', 'traveling']),
            ],
            [
                'title' => '7 Rute Rahasia Indonesia yang Tidak Ada di Peta Wisatawan Biasa (Panduan Eksklusif)',
                'slug' => '7-rute-rahasia-indonesia-' . Str::random(5),
                'excerpt' => 'Jelajahi destinasi tersembunyi Indonesia yang belum terjamah wisatawan massal. Panduan eksklusif ke tempat-tempat menakjubkan.',
                'content' => '<p>Indonesia memiliki ribuan destinasi yang belum banyak diketahui wisatawan. Berikut adalah 7 rute rahasia yang wajib Anda kunjungi untuk pengalaman traveling yang unik.</p><h2>1. Desa Wae Rebo - Flores</h2><p>Desa tradisional di atas awan dengan rumah khas berbentuk kerucut. Akses menantang namun pemandangan sangat memukau.</p><h2>2. Danau Labuan Cermin - Kalimantan</h2><p>Danau dua rasa dengan air tawar dan air asin yang tidak bercampur. Kejernihan air mencapai 5-6 meter!</p>',
                'category' => 'Hidden Gems',
                'status' => 'published',
                'view_count' => rand(8000, 20000),
                'author_id' => $authorId,
                'published_at' => now()->subDays(45),
                'tags' => json_encode(['destinasi', 'hidden gems', 'indonesia', 'adventure']),
            ],
            [
                'title' => 'Beyond Bali: 5 Destinasi Budaya Terbaik di Indonesia untuk Pecinta Sejarah',
                'slug' => 'beyond-bali-destinasi-budaya-' . Str::random(5),
                'excerpt' => 'Indonesia kaya akan warisan budaya dan sejarah. Temukan 5 destinasi yang menawarkan pengalaman budaya mendalam di luar Bali.',
                'content' => '<p>Selain Bali, Indonesia memiliki banyak destinasi dengan kekayaan budaya dan sejarah yang luar biasa. Mari jelajahi 5 tempat terbaik untuk pecinta sejarah.</p><h2>1. Yogyakarta - Jantung Budaya Jawa</h2><p>Dari Candi Borobudur hingga Keraton, Yogyakarta adalah surga bagi pencinta budaya. Jangan lewatkan pertunjukan wayang kulit dan batik traditional.</p><h2>2. Toraja - Sulawesi Selatan</h2><p>Budaya unik dengan upacara pemakaman yang spektakuler. Rumah Tongkonan yang ikonik dan pemandangan alam yang memukau.</p>',
                'category' => 'Cultural Travel',
                'status' => 'published',
                'view_count' => rand(6000, 18000),
                'author_id' => $authorId,
                'published_at' => now()->subDays(30),
                'tags' => json_encode(['budaya', 'sejarah', 'cultural', 'heritage']),
            ],
            [
                'title' => 'Jangan Sampai Salah! Ini 10 Kesalahan Fatal Saat Traveling ke Pedalaman',
                'slug' => '10-kesalahan-fatal-traveling-' . Str::random(5),
                'excerpt' => 'Hindari kesalahan umum yang bisa membahayakan perjalanan Anda ke pedalaman. Panduan safety dan persiapan yang wajib diketahui.',
                'content' => '<p>Traveling ke pedalaman membutuhkan persiapan khusus. Berikut adalah 10 kesalahan yang harus Anda hindari untuk memastikan perjalanan aman dan menyenangkan.</p><h2>1. Tidak Membawa Perlengkapan P3K</h2><p>Di pedalaman, akses ke fasilitas kesehatan sangat terbatas. Selalu bawa kotak P3K lengkap dengan obat-obatan dasar.</p><h2>2. Mengabaikan Cuaca Lokal</h2><p>Cuaca di pedalaman bisa berubah drastis. Selalu cek prakiraan cuaca dan bawa pakaian berlapis serta jas hujan.</p><h2>3. Tidak Memberitahu Itinerary ke Keluarga</h2><p>Selalu informasikan rencana perjalanan Anda ke keluarga atau teman. Ini penting untuk keamanan jika terjadi keadaan darurat.</p>',
                'category' => 'Travel Tips',
                'status' => 'published',
                'view_count' => rand(7000, 16000),
                'author_id' => $authorId,
                'published_at' => now()->subDays(15),
                'tags' => json_encode(['tips', 'safety', 'adventure', 'pedalaman']),
            ],
            [
                'title' => 'Pantai Tersembunyi di Jawa Timur: 5 Spot Instagrammable yang Belum Banyak Diketahui',
                'slug' => 'pantai-tersembunyi-jawa-timur-' . Str::random(5),
                'excerpt' => 'Jawa Timur menyimpan pantai-pantai cantik yang masih sepi pengunjung. Perfect untuk konten Instagram dan quality time.',
                'content' => '<p>Jawa Timur tidak hanya tentang Bromo dan Ijen. Ada banyak pantai tersembunyi yang menawarkan keindahan luar biasa dan sangat instagrammable!</p><h2>1. Pantai Watu Leter - Malang</h2><p>Pantai dengan formasi batu karang unik yang membentuk kolam alami. Sangat fotogenik saat sunset!</p><h2>2. Pantai Goa Cina - Malang</h2><p>Pantai eksotis dengan goa alami di tengah tebing. Ombak yang tenang cocok untuk berenang.</p>',
                'category' => 'Beach & Nature',
                'status' => 'published',
                'view_count' => rand(5000, 14000),
                'author_id' => $authorId,
                'published_at' => now()->subDays(8),
                'tags' => json_encode(['pantai', 'jawa timur', 'photography', 'instagram']),
            ],
            [
                'title' => 'Kuliner Nusantara: 15 Makanan Khas yang Wajib Dicoba di Setiap Pulau',
                'slug' => 'kuliner-nusantara-15-makanan-' . Str::random(5),
                'excerpt' => 'Perjalanan kuliner melintasi Indonesia. Dari Sabang sampai Merauke, temukan cita rasa otentik setiap daerah.',
                'content' => '<p>Indonesia adalah surga kuliner dengan ribuan jenis makanan khas. Mari kita jelajahi 15 makanan wajib coba dari berbagai pulau di Indonesia.</p><h2>Sumatra</h2><p><strong>1. Rendang Padang</strong> - Raja dari segala masakan Indonesia. Daging yang dimasak berjam-jam dengan santan dan rempah khas.</p><h2>Jawa</h2><p><strong>2. Gudeg Yogyakarta</strong> - Nangka muda yang dimasak manis dengan santan. Biasanya disajikan dengan ayam kampung, telur, dan krecek.</p>',
                'category' => 'Food & Culinary',
                'status' => 'published',
                'view_count' => rand(9000, 22000),
                'author_id' => $authorId,
                'published_at' => now()->subDays(4),
                'tags' => json_encode(['kuliner', 'makanan', 'food', 'traditional']),
            ],
        ];

        foreach ($blogs as $blogData) {
            Blog::create([
                'id' => Str::uuid(),
                'title' => $blogData['title'],
                'slug' => $blogData['slug'],
                'excerpt' => $blogData['excerpt'],
                'content' => $blogData['content'],
                'category' => $blogData['category'],
                'status' => $blogData['status'],
                'view_count' => $blogData['view_count'],
                'author_id' => $blogData['author_id'],
                'published_at' => $blogData['published_at'],
                'tags' => $blogData['tags'],
            ]);
        }

        $this->command->info('✅ ' . count($blogs) . ' blogs created successfully!');
        $this->command->info('📝 All blogs are published and ready to display');
>>>>>>> development
    }
}
