<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Blog;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
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
            // Data lama
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
