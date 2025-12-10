<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LandingPageSection;
use Illuminate\Support\Str;

class AdditionalLandingPageSectionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sections = [
            [
                'section_name' => 'Hero Banner',
                'section_title' => 'Welcome Section',
                'section_type' => 'hero',
                'section_data' => [
                    'title' => 'Bangun Website Profesional',
                    'subtitle' => 'Mudah, Cepat, dan Aman',
                    'button_text' => 'Mulai Sekarang',
                    'button_link' => '/contact',
                    'image' => 'hero.jpg'
                ],
                'order' => 10,
                'is_visible' => false,
            ],
            [
                'section_name' => 'About Us',
                'section_title' => 'Tentang Kami',
                'section_type' => 'about',
                'section_data' => [
                    'heading' => 'Tentang Kami',
                    'description' => 'Kami bergerak di bidang teknologi sejak 2020.',
                    'image' => 'about.jpg'
                ],
                'order' => 11,
                'is_visible' => false,
            ],
            [
                'section_name' => 'Features',
                'section_title' => 'Fitur Unggulan',
                'section_type' => 'features',
                'section_data' => [
                    'items' => [
                        [
                            'icon' => 'ti-code',
                            'title' => 'Clean Code',
                            'description' => 'Struktur rapi dan mudah dikembangkan'
                        ],
                        [
                            'icon' => 'ti-lock',
                            'title' => 'Secure',
                            'description' => 'Keamanan terjamin'
                        ],
                        [
                            'icon' => 'ti-rocket',
                            'title' => 'Fast Performance',
                            'description' => 'Loading cepat dan optimal'
                        ]
                    ]
                ],
                'order' => 12,
                'is_visible' => false,
            ],
            [
                'section_name' => 'Services',
                'section_title' => 'Layanan Kami',
                'section_type' => 'services',
                'section_data' => [
                    'items' => [
                        [
                            'title' => 'Web Development',
                            'description' => 'Pembuatan website Laravel',
                            'icon' => 'ti-world'
                        ],
                        [
                            'title' => 'Mobile App',
                            'description' => 'Aplikasi Android & iOS',
                            'icon' => 'ti-device-mobile'
                        ]
                    ]
                ],
                'order' => 13,
                'is_visible' => false,
            ],
            [
                'section_name' => 'Testimonials',
                'section_title' => 'Apa Kata Mereka',
                'section_type' => 'testimonial',
                'section_data' => [
                    'items' => [
                        [
                            'name' => 'Andi Setiawan',
                            'message' => 'Pelayanannya sangat memuaskan',
                            'photo' => 'andi.jpg',
                            'position' => 'CEO Startup'
                        ],
                        [
                            'name' => 'Budi Santoso',
                            'message' => 'Hasil kerjanya profesional dan tepat waktu',
                            'photo' => 'budi.jpg',
                            'position' => 'Business Owner'
                        ]
                    ]
                ],
                'order' => 14,
                'is_visible' => false,
            ],
            [
                'section_name' => 'Call To Action',
                'section_title' => 'Hubungi Kami',
                'section_type' => 'cta',
                'section_data' => [
                    'text' => 'Siap memulai project bersama kami?',
                    'button_text' => 'Hubungi Sekarang',
                    'button_link' => '/contact'
                ],
                'order' => 15,
                'is_visible' => false,
            ],
            [
                'section_name' => 'FAQ',
                'section_title' => 'Pertanyaan Umum',
                'section_type' => 'faq',
                'section_data' => [
                    'items' => [
                        [
                            'question' => 'Apakah bisa request fitur?',
                            'answer' => 'Bisa, silakan hubungi kami untuk diskusi fitur yang diinginkan'
                        ],
                        [
                            'question' => 'Berapa lama proses pengerjaan?',
                            'answer' => 'Tergantung kompleksitas project, biasanya 2-4 minggu'
                        ]
                    ]
                ],
                'order' => 16,
                'is_visible' => false,
            ],
            [
                'section_name' => 'Gallery',
                'section_title' => 'Portfolio Kami',
                'section_type' => 'gallery',
                'section_data' => [
                    'images' => [
                        'gallery1.jpg',
                        'gallery2.jpg',
                        'gallery3.jpg',
                        'gallery4.jpg'
                    ]
                ],
                'order' => 17,
                'is_visible' => false,
            ],
            [
                'section_name' => 'Contact Info',
                'section_title' => 'Hubungi Kami',
                'section_type' => 'contact',
                'section_data' => [
                    'address' => 'Jl. Merdeka No. 1, Jakarta',
                    'email' => 'info@example.com',
                    'phone' => '08123456789',
                    'map_embed' => ''
                ],
                'order' => 18,
                'is_visible' => false,
            ],
        ];

        foreach ($sections as $section) {
            // Check if section already exists
            $exists = LandingPageSection::where('section_type', $section['section_type'])->exists();

            if (!$exists) {
                LandingPageSection::create($section);
            }
        }

        $this->command->info('Additional landing page sections seeded successfully!');
    }
}
