<?php

namespace Database\Seeders\Testing;

use App\Models\Blog;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TestBlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * Creates 50 test blog posts with 'sejarah-indonesia' tag for pagination testing
     */
    public function run(): void
    {
        // Get the first user as author, or create a test user
        $author = User::first();
        
        if (!$author) {
            $this->command->error('No users found in database. Please create a user first.');
            return;
        }

        $this->command->info('Creating 50 test blogs with tag "sejarah-indonesia"...');

        $titles = [
            'Sejarah Kerajaan Majapahit di Indonesia',
            'Perjuangan Kemerdekaan Indonesia',
            'Masa Kejayaan Kerajaan Sriwijaya',
            'Perang Diponegoro dan Perlawanan terhadap Belanda',
            'Kerajaan Mataram Kuno di Jawa Tengah',
            'Sistem Pemerintahan Kerajaan Hindu-Buddha',
            'Perdagangan Maritim Nusantara Abad ke-15',
            'Masuknya Islam ke Indonesia',
            'Perjanjian Giyanti dan Perpecahan Mataram',
            'Peran Wanita dalam Sejarah Indonesia',
        ];

        $excerpts = [
            'Kerajaan besar yang pernah menguasai hampir seluruh Nusantara dengan sistem pemerintahan yang kuat dan terorganisir.',
            'Perjalanan panjang bangsa Indonesia meraih kemerdekaan dari penjajahan Belanda yang berlangsung ratusan tahun.',
            'Kerajaan maritim terbesar di Asia Tenggara yang menguasai jalur perdagangan Selat Malaka.',
            'Perlawanan heroik rakyat Jawa melawan kolonialisme Belanda di bawah kepemimpinan Pangeran Diponegoro.',
            'Masa keemasan peradaban Hindu-Buddha di Indonesia dengan peninggalan candi yang megah.',
            'Struktur birokrasi dan administrasi kerajaan-kerajaan Hindu-Buddha di Nusantara.',
            'Jalur perdagangan rempah-rempah yang menghubungkan Indonesia dengan berbagai negara di dunia.',
            'Proses islamisasi Nusantara melalui jalur perdagangan dan penyebaran para wali.',
            'Peristiwa bersejarah yang memecah Kerajaan Mataram menjadi dua wilayah kekuasaan.',
            'Kontribusi tokoh-tokoh perempuan dalam perjuangan kemerdekaan dan pembangunan bangsa.',
        ];

        for ($i = 1; $i <= 50; $i++) {
            $titleIndex = ($i - 1) % count($titles);
            $title = $titles[$titleIndex] . ' - Bagian ' . $i;
            $slug = Str::slug($title);

            Blog::create([
                'title' => $title,
                'slug' => $slug,
                'content' => '<p>Ini adalah konten blog test untuk pengujian pagination. ' . 
                            'Lorem ipsum dolor sit amet, consectetur adipiscing elit. ' .
                            'Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. ' .
                            'Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris.</p>' .
                            '<p>Sejarah Indonesia penuh dengan peristiwa penting yang membentuk bangsa ini. ' .
                            'Dari masa kerajaan Hindu-Buddha, masuknya Islam, hingga perjuangan kemerdekaan, ' .
                            'setiap periode memiliki cerita dan pelajaran berharga.</p>',
                'excerpt' => $excerpts[$titleIndex],
                'featured_image' => 'https://via.placeholder.com/800x600/3498db/ffffff?text=Blog+Test+' . $i,
                'author_id' => $author->id,
                'category' => 'Sejarah',
                'tags' => ['sejarah-indonesia', 'test-blog'],
                'status' => 'published',
                'published_at' => now()->subDays(rand(0, 365)),
                'view_count' => rand(10, 1000),
                'meta_title' => $title,
                'meta_description' => $excerpts[$titleIndex],
                'meta_keywords' => 'sejarah, indonesia, test, blog',
            ]);

            if ($i % 10 == 0) {
                $this->command->info("Created {$i} blogs...");
            }
        }

        $this->command->info('Successfully created 50 test blogs!');
        $this->command->warn('Remember to run DeleteTestBlogSeeder to remove these test blogs after testing.');
    }
}
