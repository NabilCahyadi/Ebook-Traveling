<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Creator;
use App\Models\User;
use Illuminate\Support\Str;
use Carbon\Carbon;

class CreatorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $creators = [
            [
                'email' => 'andi.wijaya@creator.com',
                'name' => 'Andi Wijaya',
                'pen_name' => 'Andi Traveler',
                'bio' => 'Penulis dan fotografer perjalanan yang telah menjelajahi lebih dari 50 kota di Indonesia. Spesialisasi dalam kuliner dan budaya lokal.',
                'avatar' => 'https://ui-avatars.com/api/?name=Andi+Traveler&size=200',
                'social_media_links' => json_encode([
                    'instagram' => 'https://instagram.com/anditraveler',
                    'twitter' => 'https://twitter.com/anditraveler',
                ]),
            ],
            [
                'email' => 'siti.nurhaliza@creator.com',
                'name' => 'Siti Nurhaliza',
                'pen_name' => 'Siti Explorer',
                'bio' => 'Pencinta sejarah dan budaya Indonesia. Telah menulis lebih dari 20 buku panduan wisata dengan fokus pada situs bersejarah.',
                'avatar' => 'https://ui-avatars.com/api/?name=Siti+Explorer&size=200',
                'social_media_links' => json_encode([
                    'instagram' => 'https://instagram.com/sitiexplorer',
                    'facebook' => 'https://facebook.com/sitiexplorer',
                ]),
            ],
            [
                'email' => 'budi.santoso@creator.com',
                'name' => 'Budi Santoso',
                'pen_name' => 'Budget Traveler Budi',
                'bio' => 'Ahli dalam traveling dengan budget terbatas. Berbagi tips dan trik untuk menjelajah Indonesia dengan biaya minimal.',
                'avatar' => 'https://ui-avatars.com/api/?name=Budget+Budi&size=200',
                'social_media_links' => json_encode([
                    'youtube' => 'https://youtube.com/budgettraveler',
                    'instagram' => 'https://instagram.com/budgettravelerbudi',
                ]),
            ],
            [
                'email' => 'dewi.lestari@creator.com',
                'name' => 'Dewi Lestari',
                'pen_name' => 'Dewi Wanderlust',
                'bio' => 'Travel blogger dan content creator yang fokus pada wisata alam dan petualangan ekstrem di Indonesia.',
                'avatar' => 'https://ui-avatars.com/api/?name=Dewi+Wanderlust&size=200',
                'social_media_links' => json_encode([
                    'instagram' => 'https://instagram.com/dewiwanderlust',
                    'tiktok' => 'https://tiktok.com/@dewiwanderlust',
                ]),
            ],
            [
                'email' => 'rudi.hartono@creator.com',
                'name' => 'Rudi Hartono',
                'pen_name' => 'Foodie Rudi',
                'bio' => 'Food enthusiast yang telah mencicipi kuliner dari berbagai daerah di Indonesia. Spesialis dalam street food dan kuliner tradisional.',
                'avatar' => 'https://ui-avatars.com/api/?name=Foodie+Rudi&size=200',
                'social_media_links' => json_encode([
                    'instagram' => 'https://instagram.com/foodierudi',
                    'youtube' => 'https://youtube.com/foodierudi',
                ]),
            ],
        ];

        foreach ($creators as $creatorData) {
            // Buat atau update user
            $user = User::updateOrCreate(
                ['email' => $creatorData['email']],
                [
                    'name' => $creatorData['name'],
                    'password' => bcrypt('password123'),
                    'user_type' => 'creator',
                    'email_verified_at' => Carbon::now(),
                ]
            );

            // Buat atau update creator profile
            Creator::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'pen_name' => $creatorData['pen_name'],
                    'bio' => $creatorData['bio'],
                    'avatar' => $creatorData['avatar'],
                    'social_media_links' => $creatorData['social_media_links'],
                    'is_active' => true,
                ]
            );

            $this->command->info("✅ Creator '{$creatorData['pen_name']}' created/updated successfully!");
        }

        $this->command->info('\n✅ All creators have been seeded!');
    }
}
