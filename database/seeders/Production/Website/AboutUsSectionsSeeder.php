<?php

namespace Database\Seeders\Production\Website;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AboutUsSectionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Hapus data lama untuk menghindari duplikasi
        DB::table('about_us_sections')->delete();

        $sections = [
            [
                'section_key'   => 'welcome',
                'title'         => 'Welcome to MeatMap',
                'content'       => '<p>We are a premium platform dedicated to travel enthusiasts. We provide an exclusive collection of Travel ebooks with a simple and affordable monthly subscription model. Our goal is to be the most complete and reliable source of information for every adventurer, offering guides, inspiration, and travel stories from various destinations worldwide.</p><p>The shopping and reading experience is designed to be as easy as possible, starting from the main page which presents various ebook categories per destination, up to a fast and integrated subscription process.</p>',
                'image'         => 'images/blogs/6.webp',
                'layout_type'   => 'image_left',
                'order_index'   => 1,
                'is_active'     => true,
            ],
            [
                'section_key'   => 'performance',
                'title'         => 'Your Partner for e-commerce grocery solution',
                'content'       => '<p>Ed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.</p><p>Pitatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.</p>',
                'image'         => 'images/blogs/3.webp',
                'layout_type'   => 'image_left',
                'order_index'   => 2,
                'is_active'     => true,
            ],
            [
                'section_key'   => 'about_details',
                'title'         => 'Learn More About Us',
                // Konten untuk 3 kolom disimpan dalam format JSON
                'content'       => json_encode([
                    [
                        'title' => 'Who we are',
                        'description' => 'Volutpat diam ut venenatis tellus in metus. Nec dui nunc mattis enim ut tellus eros donec ac odio orci ultrices in. Ellus eros donec ac odio orci ultrices in.'
                    ],
                    [
                        'title' => 'Our history',
                        'description' => 'Volutpat diam ut venenatis tellus in metus. Nec dui nunc mattis enim ut tellus eros donec ac odio orci ultrices in. Ellus eros donec ac odio orci ultrices in.'
                    ],
                    [
                        'title' => 'Our mission',
                        'description' => 'Volutpat diam ut venenatis tellus in metus. Nec dui nunc mattis enim ut tellus eros donec ac odio orci ultrices in. Ellus eros donec ac odio orci ultrices in.'
                    ]
                ]),
                'image'         => null, // Tidak perlu gambar untuk layout ini
                'layout_type'   => 'three_columns',
                'order_index'   => 3,
                'is_active'     => true,
            ],
        ];

        DB::table('about_us_sections')->insert($sections);
    }
}
