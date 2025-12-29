<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ebook;
use App\Models\Category;
use App\Models\City;
use App\Models\User;
use App\Models\Creator;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class EbookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Cek apakah data master sudah ada
        if (City::count() === 0 || Category::count() === 0) {
            $this->command->error('Jalankan CitySeeder dan CategorySeeder terlebih dahulu!');
            return;
        }

        if (Creator::count() === 0) {
            $this->command->error('Jalankan CreatorSeeder terlebih dahulu!');
            return;
        }

        // 2. Ambil semua ID dari cities, categories, dan creators untuk efisiensi
        $cityMap = City::pluck('id', 'slug')->all();
        $categoryMap = Category::pluck('id', 'slug')->all();
        // Ambil user_id dari creators karena FK ebooks.creator_id mengarah ke users
        $creatorMap = Creator::pluck('user_id', 'pen_name')->all();

        // 3. Definisikan data e-book dengan slug untuk kemudahan
        $ebooks = [
            [
                'title' => 'Panduan Lengkap Wisata Kuliner Jakarta',
                'slug' => 'panduan-lengkap-wisata-kuliner-jakarta',
                'creator_pen_name' => 'Foodie Rudi',
                'description' => 'Ebook ini membahas secara mendalam berbagai kuliner khas Jakarta, dari street food hingga restoran mewah. Temukan tempat-tempat tersembunyi yang wajib dikunjungi oleh pecinta kuliner.',
                'short_description' => 'Jelajahi kekayaan rasa Jakarta dengan panduan ini.',
                'cover_image' => 'https://i0.wp.com/bintangpustaka.com/wp-content/uploads/2022/10/JELAJAH-KULINER-KHAS-BETAWI_FRONTCOVER.png?fit=1857%2C2787&ssl=1',
                'pdf_file' => '/images/sampel-1.pdf',
                'language' => 'id',
                'city_slug' => 'jakarta', // Gunakan slug
                'category_slugs' => ['kuliner', 'panduan-wisata'], // Gunakan array slug
                'total_pages' => 10,
                'status' => 'published',
            ],
            [
                'title' => 'Sejarah Bandung Dulu dan Kini',
                'slug' => 'sejarah-bandung-dulu-dan-kini',
                'creator_pen_name' => 'Siti Explorer',
                'description' => 'Mengupas tuntas sejarah kota Bandung dari masa kerajaan Sunda hingga menjadi kota metropolitan. Dilengkapi dengan foto-foto bersejarah.',
                'short_description' => 'Perjalanan panjang kota kembang.',
                'cover_image' => 'https://mantra.family.blog/wp-content/uploads/2020/11/9950a-pesona2bbandung2bocer.jpg',
                'pdf_file' => '/images/sampel-1.pdf',
                'language' => 'id',
                'city_slug' => 'bandung',
                'category_slugs' => ['budaya-sejarah'],
                'total_pages' => 10,
                'status' => 'published',
            ],
            [
                'title' => 'Misteri Kota Tua Jakarta',
                'slug' => 'misteri-kota-tua-jakarta',
                'creator_pen_name' => 'Siti Explorer',
                'description' => 'Menggali lebih dalam sejarah, mitos, dan kisah di balik bangunan-bangunan bersejarah di kawasan Kota Tua Jakarta. Dari VOC hingga kini, temukan sisi lain dari ibu kota.',
                'short_description' => 'Eksplorasi sejarah dan mitos di balik dinding Kota Tua.',
                'cover_image' => 'https://img.bukabuku.net/product/1/9/19ed9e2e6b21e5b35b09ae2ba609acec.jpg',
                'pdf_file' => '/images/sampel-1.pdf',
                'language' => 'id',
                'city_slug' => 'jakarta',
                'category_slugs' => ['budaya-sejarah', 'wisata-religi'],
                'total_pages' => 10,
                'status' => 'published',
            ],
            [
                'title' => 'Backpacking di Bali dengan Budget 1 Juta',
                'slug' => 'backpacking-bali-budget-1-juta',
                'creator_pen_name' => 'Budget Traveler Budi',
                'description' => 'Panduan lengkap untuk menjelajahi keindahan Bali dengan kantong tipis. Dari penginapan murah, kuliner hemat, hingga tempat wisata gratis, semua ada di sini.',
                'short_description' => 'Jelajahi Bali tanpa khawatir kantong kering.',
                'cover_image' => 'https://www.willflyforfood.net/wp-content/uploads/2019/06/bali-travel-guide-pinterest.jpg.webp',
                'pdf_file' => '/images/sampel-1.pdf',
                'language' => 'id',
                'city_slug' => 'denpasar', // Asumsi ada kota Denpasar
                'category_slugs' => ['budget-travel', 'tips-trik'],
                'total_pages' => 10,
                'status' => 'published',
            ],
            [
                'title' => 'Pesona Wisata Alam Sumatera Barat',
                'slug' => 'pesona-wisata-alam-sumatera-barat',
                'creator_pen_name' => 'Dewi Wanderlust',
                'description' => 'Menjelajahi keindahan alam Sumatera Barat, dari Danau Toba yang megah hingga pulau-pulau eksotis di Mentawai. Panduan sempurna untuk petualang alam.',
                'short_description' => 'Petualangan alam di ujung barat Sumatera.',
                'cover_image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQEaWCwmmbajWy-pXrxgQs7CMuto1TSNCLTqA&s',
                'pdf_file' => '/images/sampel-1.pdf',
                'language' => 'id',
                'city_slug' => 'padang', // Asumsi ada kota Padang
                'category_slugs' => ['wisata-alam', 'petualangan'],
                'total_pages' => 10,
                'status' => 'published',
            ],
            [
                'title' => 'Kuliner Khas Surabaya yang Wajib Dicoba',
                'slug' => 'kuliner-khas-surabaya',
                'creator_pen_name' => 'Foodie Rudi',
                'description' => 'Rasa lain dari Surabaya. Temukan cita rasa autentik dari Sate Klopo, Lontong Balap, hingga Rawon Setan dalam panduan kuliner ini.',
                'short_description' => 'Jelajahi kekayaan rasa kota Pahlawan.',
                'cover_image' => 'https://cdn.gramedia.com/uploads/items/9786020633497_nyonya_rumah_R5-1.jpg',
                'pdf_file' => '/images/sampel-1.pdf',
                'language' => 'id',
                'city_slug' => 'surabaya',
                'category_slugs' => ['kuliner'],
                'total_pages' => 10,
                'status' => 'published',
            ],
            [
                'title' => 'Fotografi Landscape: Teknik & Lokasi',
                'slug' => 'fotografi-landscape-teknik-lokasi',
                'creator_pen_name' => 'Andi Traveler',
                'description' => 'Menguasai seni fotografi landscape. Pelajari teknik komposisi, pengaturan kamera, hingga rekomendasi lokasi-lokasi terbaik di Indonesia.',
                'short_description' => 'Tangkap keindahan alam Indonesia dalam foto.',
                'cover_image' => 'https://i0.wp.com/digital-photography-school.com/wp-content/uploads/2013/08/1.-Moraine_final.jpg?w=600&h=1260&ssl=1',
                'pdf_file' => '/images/sampel-1.pdf',
                'language' => 'id',
                'city_slug' => 'yogyakarta',
                'category_slugs' => ['fotografi', 'tips-trik'],
                'total_pages' => 10,
                'status' => 'published',
            ],
            [
                'title' => 'Akomodasi Unik di Yogyakarta',
                'slug' => 'akomodasi-unik-yogyakarta',
                'creator_pen_name' => 'Andi Traveler',
                'description' => 'Ingin pengalaman menginap yang berbeda di Yogyakarta? Dari homestay di desa wisata hingga glamping di dekat Candi Borobudur, temukan di sini.',
                'short_description' => 'Tempat tinggal unik di kota Gudeg.',
                'cover_image' => 'https://static.vecteezy.com/system/resources/thumbnails/022/915/693/small/magazine-or-book-cover-template-for-tourism-calender-with-yogyakarta-culture-illustration-vector.jpg',
                'pdf_file' => '/images/sampel-1.pdf',
                'language' => 'id',
                'city_slug' => 'yogyakarta',
                'category_slugs' => ['akomodasi'],
                'total_pages' => 10,
                'status' => 'published',
            ],
            [
                'title' => 'Transportasi Darat di Indonesia: Panduan Lengkap',
                'slug' => 'transportasi-darat-indonesia-panduan',
                'creator_pen_name' => 'Siti Explorer',
                'description' => 'Semua yang perlu Anda tahu tentang transportasi darat di Indonesia. Dari cara naik bus, kereta api, hingga tips naik ojek online.',
                'short_description' => 'Panduan lengkap bepergian darat di Nusantara.',
                'cover_image' => 'https://www.lemon8-app.com/seo/image?item_id=7457349749536997905&index=0&sign=8552ba833800981eb781dcf529e748fc',
                'pdf_file' => '/images/sampel-1.pdf',
                'language' => 'id',
                'city_slug' => 'jakarta',
                'category_slugs' => ['transportasi', 'tips-trik'],
                'total_pages' => 10,
                'status' => 'published',
            ],
            [
                'title' => 'Menyelam di Taman Nasional Bunaken',
                'slug' => 'menyelam-bunaken',
                'creator_pen_name' => 'Budget Traveler Budi',
                'description' => 'Panduan lengkap untuk menyelam di Taman Nasional Bunaken. Temukan spot-spot diving terbaik, jenis-jenis ikan, dan cara menjaga kelestarian terumbu karang.',
                'short_description' => 'Jelajahi bawah laut Bunaken yang menakjubkan.',
                'cover_image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ82Sm6RT2pT-z5yktCVEEQtFgJtHcm3L55-A&s',
                'pdf_file' => '/images/sampel-1.pdf',
                'language' => 'id',
                'city_slug' => 'manado',
                'category_slugs' => ['wisata-alam', 'petualangan'],
                'total_pages' => 10,
                'status' => 'published',
            ],
            [
                'title' => 'Sejarah Kerajaan Majapahit',
                'slug' => 'sejarah-kerajaan-majapahit',
                'creator_pen_name' => 'Dewi Wanderlust',
                'description' => 'Kisah megah kerajaan Majapahit yang pernah berjaya di Nusantara. Dari asal-usul, puncak kejayaan, hingga runtuhnya, semua terangkum di sini.',
                'short_description' => 'Mengungkap kejayaan kerajaan di ujung timur.',
                'cover_image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTcvNcFzuYgh7w-MUurstUF5lAipADQO4J4kA&s',
                'pdf_file' => '/images/sampel-1.pdf',
                'language' => 'id',
                'city_slug' => 'mojokerto', // Asumsi ada kota Mojokerto
                'category_slugs' => ['budaya-sejarah'],
                'total_pages' => 10,
                'status' => 'published',
            ],
            [
                'title' => 'Tips & Trik Traveling untuk Keluarga',
                'slug' => 'tips-trik-traveling-keluarga',
                'creator_pen_name' => 'Foodie Rudi',
                'description' => 'Traveling bersama keluarga, terutama dengan anak-anak, butuh persiapan ekstra. Dapatkan tips dan trik agar liburan keluarga Anda menyenangkan dan bebas stres.',
                'short_description' => 'Liburan seru bersama orang tersayang.',
                'cover_image' => 'https://kubuku.id/api/generic/showCover/BK72347',
                'pdf_file' => '/images/sampel-1.pdf',
                'language' => 'id',
                'city_slug' => 'bandung',
                'category_slugs' => ['family-travel', 'tips-trik'],
                'total_pages' => 10,
                'status' => 'published',
            ],
            [
                'title' => 'Festival & Event di Indonesia Sepanjang Tahun',
                'slug' => 'festival-event-indonesia',
                'creator_pen_name' => 'Andi Traveler',
                'description' => 'Indonesia kaya akan festival dan event budaya. Dari Waisak di Borobudur hingga Festival Danau Toba, dapatkan jadwal dan panduan lengkapnya di sini.',
                'short_description' => 'Jangan lewatkan festival-festival menarik di Indonesia.',
                'cover_image' => 'https://thebookcoverdesigner.com/wp-content/uploads/2015/08/Guide-to-travelling.jpg',
                'pdf_file' => '/images/sampel-1.pdf',
                'language' => 'id',
                'city_slug' => 'jakarta',
                'category_slugs' => ['musim-festival'],
                'total_pages' => 10,
                'status' => 'published',
            ],
            [
                'title' => 'Kesehatan & Keamanan Saat Traveling',
                'slug' => 'kesehatan-keamanan-traveling',
                'creator_pen_name' => 'Siti Explorer',
                'description' => 'Penting! Panduan menjaga kesehatan dan keamanan saat traveling. Dari vaksin, asuransi perjalanan, hingga tips menghindari penipuan.',
                'short_description' => 'Aman dan sehat di mana pun Anda berada.',
                'cover_image' => 'https://eatdrinktravelmag.com.au/wp-content/uploads/2023/06/Eat-Drink-Travel-Magazine-Issue-1-Cover.jpg',
                'pdf_file' => '/images/sampel-1.pdf',
                'language' => 'id',
                'city_slug' => 'surabaya',
                'category_slugs' => ['kesehatan-keamanan', 'tips-trik'],
                'total_pages' => 10,
                'status' => 'published',
            ],
            [
                'title' => 'Digital Nomad: Bekerja dari Mana Saja',
                'slug' => 'digital-nomad-bekerja-dari-mana-saja',
                'creator_pen_name' => 'Budget Traveler Budi',
                'description' => 'Ingin bekerja sambil keliling dunia? Pelajari cara menjadi digital nomad, mencari pekerjaan remote, dan tips menyeimbangkan kerja dan petualangan.',
                'short_description' => 'Bebaskan diri Anda, kerja dari mana saja.',
                'cover_image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR29gc-pBAUTTmcsaCaC-7dHkrK2nDEQvaurA&s',
                'pdf_file' => '/images/sampel-1.pdf',
                'language' => 'id',
                'city_slug' => 'bali',
                'category_slugs' => ['digital-nomad', 'tips-trik'],
                'total_pages' => 10,
                'status' => 'published',
            ],
            [
                'title' => 'Belanja & Shopping di Bangkok',
                'slug' => 'belanja-shopping-bangkok',
                'creator_pen_name' => 'Dewi Wanderlust',
                'description' => 'Panduan lengkap untuk berbelanja di Bangkok, dari pasar tradisional seperti Chatuchak hingga mal-mal mewah di Siam Paragon. Dapatkan tips tawar-menawar dan barang apa saja yang harus dibeli.',
                'short_description' => 'Hobi belanja? Bangkok adalah surganya!',
                'cover_image' => 'https://d1csarkz8obe9u.cloudfront.net/posterpreviews/travel-magazine-cover-design-template-25b6a0998bdc41275f20e8ac9de32870_screen.jpg?ts=1734238834',
                'pdf_file' => '/images/sampel-1.pdf',
                'language' => 'id',
                'city_slug' => 'jakarta', // Karena ini buku panduan, lokasi penerbitan tidak harus Bangkok
                'category_slugs' => ['belanja-shopping', 'luxury-travel'],
                'total_pages' => 10,
                'status' => 'published',
            ],
            [
                'title' => 'Kehidupan Malam di Jakarta',
                'slug' => 'kehidupan-malam-jakarta',
                'creator_pen_name' => 'Foodie Rudi',
                'description' => 'Jakarta tidak pernah tidur. Jelajahi sisi lain Jakarta setelah matahari terbenam. Dari bar, club, hingga street food malam, semua ada di sini.',
                'short_description' => 'Eksplorasi gemerlapnya Jakarta malam hari.',
                'cover_image' => 'https://d1csarkz8obe9u.cloudfront.net/posterpreviews/travel-magazine-cover-template-design-e20a20ddb472c2ad1f404359694abb97_screen.jpg?ts=1734801635',
                'pdf_file' => '/images/sampel-1.pdf',
                'language' => 'id',
                'city_slug' => 'jakarta',
                'category_slugs' => ['kehidupan-malam'],
                'total_pages' => 10,
                'status' => 'published',
            ],
            [
                'title' => 'Wisata Anak: Destinasi Ramah Anak di Indonesia',
                'slug' => 'wisata-anak-destinasi-ramah-anak',
                'creator_pen_name' => 'Andi Traveler',
                'description' => 'Mencari destinasi liburan keluarga yang ramah untuk anak-anak? Dari taman bermain, museum interaktif, hingga pantai dengan ombak tenang, temukan di sini.',
                'short_description' => 'Liburan seru dan aman untuk buah hati tercinta.',
                'cover_image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRi-39G0AaEH5PVna6eFUVfq4GUtQ8HOe4juQ&s',
                'pdf_file' => '/images/sampel-1.pdf',
                'language' => 'id',
                'city_slug' => 'bandung',
                'category_slugs' => ['wisata-anak', 'family-travel'],
                'total_pages' => 10,
                'status' => 'published',
            ],
            [
                'title' => 'Wisata Edukasi: Museum & Situs Bersejarah',
                'slug' => 'wisata-edukasi-museum-situs-bersejarah',
                'creator_pen_name' => 'Siti Explorer',
                'description' => 'Liburan sambil belajar. Kunjungi museum-museum dan situs bersejarah penting di Indonesia. Dapatkan informasi sejarah dan edukasi yang menarik.',
                'short_description' => 'Jelajahi sejarah dan budaya Indonesia secara langsung.',
                'cover_image' => 'https://bookcover4u.com/pro/Adventures-book-cover-design-travel-vector-book-cover-design-vacation-trip-adventure-covers-outdoor-travelling-flat-journey-guide-N1550142480B.jpg',
                'pdf_file' => '/images/sampel-1.pdf',
                'language' => 'id',
                'city_slug' => 'yogyakarta',
                'category_slugs' => ['wisata-edukasi', 'budaya-sejarah'],
                'total_pages' => 10,
                'status' => 'published',
            ],
            [
                'title' => 'Luxury Travel: Pengalaman Premium di Indonesia',
                'slug' => 'luxury-travel-pengalaman-premium',
                'creator_pen_name' => 'Budget Traveler Budi',
                'description' => 'Rasakan pengalaman traveling paling mewah di Indonesia. Dari menginap di resort bintang 5, menumpang pesawat kelas satu, hingga layanan VIP eksklusif.',
                'short_description' => 'Nikmati kemewahan dan kenyamanan saat berlibur.',
                'cover_image' => 'https://bookcover4u.com/pro/Nonfiction-book-cover-design-P1484806926NOB-World-Traveling-Guide-traveling-educational-world-traveling.jpg',
                'pdf_file' => '/images/sampel-1.pdf',
                'language' => 'id',
                'city_slug' => 'jakarta',
                'category_slugs' => ['luxury-travel'],
                'total_pages' => 10,
                'status' => 'published',
            ],
            [
                'title' => 'Petualangan di Gunung Rinjani',
                'slug' => 'petualangan-gunung-rinjani',
                'creator_pen_name' => 'Dewi Wanderlust',
                'description' => 'Panduan lengkap untuk mendaki Gunung Rinjani. Dari persiapan fisik, jalur pendakian, tips keselamatan, hingga cerita dari puncak.',
                'short_description' => 'Taklukkan puncak Rinjani, tantangan para pendaki.',
                'cover_image' => 'https://d1csarkz8obe9u.cloudfront.net/posterpreviews/animated-travel-book-cover-kindle-template-design-b5c06c99b9e5afd270273a97b5b1d60f.jpg?ts=1637034260',
                'pdf_file' => '/images/sampel-1.pdf',
                'language' => 'id',
                'city_slug' => 'mataram', // Asumsi ada kota Mataram
                'category_slugs' => ['petualangan', 'wisata-alam'],
                'total_pages' => 10,
                'status' => 'published',
            ],
            [
                'title' => 'Kuliner Nusantara: Jelajahi Rasa Indonesia',
                'slug' => 'kuliner-nusantara-jelajahi-rasa-indonesia',
                'creator_pen_name' => 'Foodie Rudi',
                'description' => 'Indonesia adalah surga kuliner. Jelajahi kekayaan rasa dari Sabang hingga Merauke. Dari Rendang hingga Pempek, semua ada dalam panduan ini.',
                'short_description' => 'Perjalanan kuliner menyeluruh di Indonesia.',
                'cover_image' => 'https://www.gavamedia.net/foto_produk/14Cover%20Tour%20dan%20Travel%20Dummy_527x800.jpg',
                'pdf_file' => '/images/sampel-1.pdf',
                'language' => 'id',
                'city_slug' => 'jakarta',
                'category_slugs' => ['kuliner'],
                'total_pages' => 10,
                'status' => 'published',
            ],
            [
                'title' => 'Panduan Wisata Religi: Ziarah ke Tempat Suci',
                'slug' => 'panduan-wisata-religi-ziarah',
                'creator_pen_name' => 'Andi Traveler',
                'description' => 'Panduan lengkap untuk melakukan ziarah ke tempat-tempat suci di Indonesia. Dari masjid, gereja, pura, hingga vihara, dapatkan tata cara dan etikanya.',
                'short_description' => 'Lakukan ziarah dengan khusyuk dan tenang.',
                'cover_image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTwpl5Yorr3jPNV5xyQMCMYyBID_wDi4dEHWw&s',
                'pdf_file' => '/images/sampel-1.pdf',
                'language' => 'id',
                'city_slug' => 'demak',
                'category_slugs' => ['wisata-religi'],
                'total_pages' => 10,
                'status' => 'published',
            ],
            // 'pdf_file' => '',
        ];

        // 4. Loop dan gunakan updateOrCreate untuk setiap ebook
        foreach ($ebooks as $data) {
            // Cari ID kota berdasarkan slug
            $cityId = $cityMap[$data['city_slug']] ?? null;
            if (!$cityId) {
                $this->command->error("Kota dengan slug '{$data['city_slug']}' tidak ditemukan. Melewati e-book '{$data['title']}'.");
                continue;
            }

            // Cari ID creator berdasarkan pen_name
            $creatorId = $creatorMap[$data['creator_pen_name']] ?? null;
            if (!$creatorId) {
                $this->command->error("Creator '{$data['creator_pen_name']}' tidak ditemukan. Melewati e-book '{$data['title']}'.");
                continue;
            }

            // Cari category IDs
            $categoryIds = [];
            foreach ($data['category_slugs'] as $categorySlug) {
                if (isset($categoryMap[$categorySlug])) {
                    $categoryIds[] = $categoryMap[$categorySlug];
                } else {
                    $this->command->warn("Kategori dengan slug '{$categorySlug}' tidak ditemukan untuk e-book '{$data['title']}'.");
                }
            }

            // UpdateOrCreate ebook berdasarkan slug
            $ebook = Ebook::updateOrCreate(
                ['slug' => $data['slug']],
                [
                    'title' => $data['title'],
                    'description' => $data['description'],
                    'short_description' => $data['short_description'],
                    'cover_image' => $data['cover_image'],
                    'pdf_file' => '/images/sampel-1.pdf',
                    'language' => $data['language'],
                    'city_id' => $cityId,
                    'creator_id' => $creatorId,
                    'status' => $data['status'],
                    'published_at' => Carbon::now(),
                ]
            );

            // Handle categories - detach lalu attach dengan UUID
            $ebook->categories()->detach();

            if (!empty($categoryIds)) {
                foreach ($categoryIds as $categoryId) {
                    DB::table('ebook_categories')->insert([
                        'id' => Str::uuid()->toString(),
                        'ebook_id' => $ebook->id,
                        'category_id' => $categoryId,
                        'created_at' => Carbon::now(),
                    ]);
                }
            }

            $this->command->info("✅ Ebook '{$data['title']}' created/updated successfully!");
        }

        $this->command->info("\n✅ All ebooks have been seeded!");
    }
}
