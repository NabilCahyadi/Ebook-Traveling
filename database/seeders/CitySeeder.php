<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Kosongkan tabel terlebih dahulu agar tidak duplikat
        DB::table('cities')->delete();
        $cities = [
            // 10 Data Kota Populer (is_popular = 1)
            [
                'name' => 'Jakarta',
                'slug' => 'jakarta',
                'description' => 'Ibu kota Indonesia yang merupakan pusat bisnis, politik, dan budaya.',
                'image' => '/images/jkt.jpg',
                'province' => 'DKI Jakarta',
                'order_index' => 1,
                'is_active' => true,
                'is_popular' => true,
                // 'views_count' => 542310,
            ],
            [
                'name' => 'Surabaya',
                'slug' => 'surabaya',
                'description' => 'Kota pahlawan dan pusat bisnis terbesar di Indonesia timur.',
                'image' => 'https://lh3.googleusercontent.com/gps-cs-s/AG0ilSxn-83rEDG4n1j2nNcvioCxocV0t3oHJZwExGG5wM2txHf6h6lLAyRv-MH28zC95SwqgEwgaUQWVQMydTsSjihMeCEt9GNbIIJbaZIEeiUkSOtFNMDXsAuViBAZlzCsYV6skQU=w729-h421-n-k-no',
                'province' => 'Jawa Timur',
                'order_index' => 2,
                'is_active' => true,
                'is_popular' => true,
                // 'views_count' => 421150,
            ],
            [
                'name' => 'Bandung',
                'slug' => 'bandung',
                'description' => 'Kota kembang dengan iklim sejuk dan pusat fashion serta kuliner yang terkenal.',
                'image' => 'https://media.timeout.com/images/106211627/image.jpg',
                'province' => 'Jawa Barat',
                'order_index' => 3,
                'is_active' => true,
                'is_popular' => true,
                // 'views_count' => 398770,
            ],
            [
                'name' => 'Medan',
                'slug' => 'medan',
                'description' => 'Kota terbesar di Sumatera Utara yang terkenal dengan keberagaman budayanya.',
                'image' => '/images/mdn.jpg',
                'province' => 'Sumatera Utara',
                'order_index' => 4,
                'is_active' => true,
                'is_popular' => true,
                // 'views_count' => 312450,
            ],
            [
                'name' => 'Semarang',
                'slug' => 'semarang',
                'description' => 'Ibu kota Jawa Tengah dengan pesona kota lama dan kuliner khasnya.',
                'image' => 'https://lh3.googleusercontent.com/gps-cs-s/AG0ilSzPm72y2UC4JLCmk9K91ByylfOaipR6aIqprnCZWANacIVei1r2ntMIw87qq1176Cuu5N5KpO6lVhU_bbsKesw4az99egiIs9aCAxHMgmfhNs9yEQh__h8WzFU8CPE71LU6ZTmb=w729-h421-n-k-no',
                'province' => 'Jawa Tengah',
                'order_index' => 5,
                'is_active' => true,
                'is_popular' => true,
                // 'views_count' => 289100,
            ],
            [
                'name' => 'Makassar',
                'slug' => 'makassar',
                'description' => 'Gerbang Indonesia Timur yang terkenal dengan seafood dan sejarah Kerajaan Gowa.',
                'image' => 'https://lh3.googleusercontent.com/gps-cs-s/AG0ilSxiCMilMCt3jvL8hIZ0lt4OQmQVHW1rJED8pcKSzu7dQFD08uj-ziGZKKtrhAZoQrsShZvVCIFtjz2v2gJfQL3BHbfrH9Ld8fbx2bUe34jc7vbcmsqlV-4SeogZBzTEThzpHrtz=w729-h421-n-k-no',
                'province' => 'Sulawesi Selatan',
                'order_index' => 6,
                'is_active' => true,
                'is_popular' => true,
                // 'views_count' => 254330,
            ],
            [
                'name' => 'Palembang',
                'slug' => 'palembang',
                'description' => 'Kota pempek yang terkenal dengan Jembatan Ampera dan sejarah kerajaan Sriwijaya.',
                'image' => 'https://www.gotravelaindonesia.com/wp-content/uploads/hidden-gem-wisata-palembang.jpg',
                'province' => 'Sumatera Selatan',
                'order_index' => 7,
                'is_active' => true,
                'is_popular' => true,
                // 'views_count' => 198500,
            ],
            [
                'name' => 'Tangerang',
                'slug' => 'tangerang',
                'description' => 'Kota industri dan perumahan terbesar di Provinsi Banten.',
                'image' => 'https://dynamic-media-cdn.tripadvisor.com/media/photo-o/11/a3/b2/49/img-20171231-wa0050-largejpg.jpg?w=1200&h=-1&s=1',
                'province' => 'Banten',
                'order_index' => 8,
                'is_active' => true,
                'is_popular' => true,
                // 'views_count' => 176200,
            ],
            [
                'name' => 'Depok',
                'slug' => 'depok',
                'description' => 'Kota penyangga Jakarta yang dikenal dengan sejumlah universitas ternama.',
                'image' => 'https://assets.pikiran-rakyat.com/crop/0x0:0x0/720x0/webp/photo/2021/05/27/1406234149.jpeg',
                'province' => 'Jawa Barat',
                'order_index' => 9,
                'is_active' => true,
                'is_popular' => true,
                // 'views_count' => 165880,
            ],
            [
                'name' => 'Batam',
                'slug' => 'batam',
                'description' => 'Pusat industri dan perdagangan bebas yang dekat dengan Singapura dan Malaysia.',
                'image' => 'https://si.indobarunasional.ac.id/wp-content/uploads/2025/10/id_batam_barelang_bridge_1363161767-1170x680-1.jpg',
                'province' => 'Kepulauan Riau',
                'order_index' => 10,
                'is_active' => true,
                'is_popular' => true,
                // 'views_count' => 154900,
            ],

            // 5 Data Kota Tidak Populer (is_popular = 0)
            [
                'name' => 'Bogor',
                'slug' => 'bogor',
                'description' => 'Kota hujan dengan Kebun Raya yang terkenal dan destinasi wisata dekat Jakarta.',
                'image' => 'https://aragontrans.com/uploads/berita_image/IN_20230126110657_banner-aragon-11.jpg',
                'province' => 'Jawa Barat',
                'order_index' => 11,
                'is_active' => true,
                'is_popular' => false,
                // 'views_count' => 45200,
            ],
            [
                'name' => 'Pekanbaru',
                'slug' => 'pekanbaru',
                'description' => 'Ibu kota Provinsi Riau yang menjadi pusat perdagangan minyak dan kelapa sawit.',
                'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTHRqiEi2yIaSa8WNx04ywQrNV5WUwk_5fXZg&s',
                'province' => 'Riau',
                'order_index' => 12,
                'is_active' => true,
                'is_popular' => false,
                // 'views_count' => 38900,
            ],
            [
                'name' => 'Bandar Lampung',
                'slug' => 'bandar-lampung',
                'description' => 'Kota terbesar di Pulau Sumatera yang menjadi gerbang menuju Pulau Belitung.',
                'image' => 'https://ik.imagekit.io/tvlk/blog/2025/04/Open-Trip-One-Day-Pulau-Pahawang-Dermaga-Ketapang-Lampung-674f1082-d294-408d-b5c7-7b0a6034a480.jpeg-1024x768.webp?tr=q-70,c-at_max,w-1000,h-600',
                'province' => 'Lampung',
                'order_index' => 13,
                'is_active' => true,
                'is_popular' => false,
                // 'views_count' => 31100,
            ],
            [
                'name' => 'Malang',
                'slug' => 'malang',
                'description' => 'Kota yang sejuk dan dikelilingi oleh pegunungan, terkenal dengan apel dan wisata alam.',
                'image' => 'https://jalanjalanyuk.co.id/wp-content/uploads/2024/04/Rekomendasi-Tempat-Wisata-di-Malang.jpg',
                'province' => 'Jawa Timur',
                'order_index' => 14,
                'is_active' => true,
                'is_popular' => false,
                // 'views_count' => 27500,
            ],
            [
                'name' => 'Samarinda',
                'slug' => 'samarinda',
                'description' => 'Ibu kota Provinsi Kalimantan Timur yang terletak di tepi Sungai Mahakam.',
                'image' => 'https://mediaim.expedia.com/destination/1/846636226121733e8e9966ca3f3fe981.jpg',
                'province' => 'Kalimantan Timur',
                'order_index' => 15,
                'is_active' => true,
                'is_popular' => false,
                // 'views_count' => 21900,
            ],

            // Tambahan Data Kota yang Hilang
            [
                'name' => 'Denpasar',
                'slug' => 'denpasar',
                'description' => 'Ibu kota Bali yang menjadi gerbang utama menuju pulau dewata dengan keindahan pantainya.',
                'image' => 'https://bobobox.com/blog/wp-content//uploads/2023/10/Tempat-Wisata-di-Denpasar-1200x900.webp',
                'province' => 'Bali',
                'order_index' => 16,
                'is_active' => true,
                'is_popular' => true,
                // 'views_count' => 345600,
            ],
            [
                'name' => 'Padang',
                'slug' => 'padang',
                'description' => 'Kota terbesar di Sumatera Barat yang terkenal dengan masakan Padang dan pantainya.',
                'image' => '/images/pdg.jpg',
                'province' => 'Sumatera Barat',
                'order_index' => 17,
                'is_active' => true,
                'is_popular' => true,
                // 'views_count' => 298700,
            ],
            [
                'name' => 'Yogyakarta',
                'slug' => 'yogyakarta',
                'description' => 'Kota budaya dan pendidikan dengan Keraton Yogyakarta dan dekat dengan Candi Borobudur.',
                'image' => 'https://www.yogyes.com/id/yogyakarta-tourism-object/candi/prambanan/1.jpg',
                'province' => 'DI Yogyakarta',
                'order_index' => 18,
                'is_active' => true,
                'is_popular' => true,
                // 'views_count' => 412300,
            ],
            [
                'name' => 'Manado',
                'slug' => 'manado',
                'description' => 'Ibu kota Sulawesi Utara yang terkenal dengan Taman Nasional Bunaken dan kuliner seafoodnya.',
                'image' => 'https://blog.bookingtogo.com/wp-content/uploads/2023/12/2019-05-17.jpg',
                'province' => 'Sulawesi Utara',
                'order_index' => 19,
                'is_active' => true,
                'is_popular' => true,
                // 'views_count' => 276500,
            ],
            [
                'name' => 'Mojokerto',
                'slug' => 'mojokerto',
                'description' => 'Kota bersejarah yang menjadi bagian dari wilayah Kerajaan Majapahit di masa lalu.',
                'image' => 'https://awsimages.detik.net.id/community/media/visual/2023/09/05/wisata-sumber-gempong-mojokerto_169.jpeg?w=1200',
                'province' => 'Jawa Timur',
                'order_index' => 20,
                'is_active' => true,
                'is_popular' => false,
                // 'views_count' => 38400,
            ],
            [
                'name' => 'Bali',
                'slug' => 'bali',
                'description' => 'Pulau dewata dengan pantai indah, budaya unik, dan destinasi wisata terkenal di dunia.',
                'image' => 'https://kemenparekraf.go.id/_next/image?url=https%3A%2F%2Fapi2.kemenparekraf.go.id%2Fstorage%2Fapp%2Fuploads%2Fpublic%2F620%2Fb45%2F3fb%2F620b453fbfafa855804364.jpg&w=3840&q=75',
                'province' => 'Bali',
                'order_index' => 21,
                'is_active' => true,
                'is_popular' => true,
                // 'views_count' => 567800,
            ],
            [
                'name' => 'Mataram',
                'slug' => 'mataram',
                'description' => 'Ibu kota Provinsi Nusa Tenggara Barat yang menjadi gerbang menuju Pulau Lombok.',
                'image' => 'https://images.tokopedia.net/blog-tokopedia-com/uploads/2018/09/wisata-mataram-2-Explore-Lombok-Island.jpg',
                'province' => 'Nusa Tenggara Barat',
                'order_index' => 22,
                'is_active' => true,
                'is_popular' => true,
                // 'views_count' => 187600,
            ],
            [
                'name' => 'Demak',
                'slug' => 'demak',
                'description' => 'Kota bersejarah yang menjadi pusat penyebaran Islam di Jawa dengan Masjid Agung Demak.',
                'image' => 'https://assets.pikiran-rakyat.com/crop/0x0:0x0/720x0/webp/photo/2023/04/10/2321568865.png',
                'province' => 'Jawa Tengah',
                'order_index' => 23,
                'is_active' => true,
                'is_popular' => false,
                // 'views_count' => 29800,
            ],
        ];

        foreach ($cities as $cityData) {
            // Log untuk memastikan semua kota diproses
            // echo "Processing city: " . $cityData['name'] . "\n"; // Hapus ini setelah selesai

            // $imagePath = '/images/' . $cityData['slug'] . '.jpg';
            $fullData = array_merge($cityData, [
                'id' => Str::uuid(),
                'is_active' => true,
            ]);

            City::create($fullData);
        }

        $this->command->info('✅ Cities seeded successfully!');
        $this->command->info('📚 Total: ' . count($cities) . ' cities created.');
    }
}
