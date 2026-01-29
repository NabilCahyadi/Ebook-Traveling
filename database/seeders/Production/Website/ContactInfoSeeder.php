<?php

namespace Database\Seeders\Production\Website;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ContactInfo;
use Illuminate\Support\Facades\DB;

class ContactInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Hapus data lama untuk menghindari duplikasi saat menjalankan seeder lagi
        DB::table('contact_infos')->delete();

        // contactInfo = untuk menyimpan contact & dominan ke media sosial
        $contacts = [
            // WhatsApp
            [
                'contact_type' => 'whatsapp',
                'title'       => 'WhatsApp Support',
                'description' => 'Chat dengan kami untuk respons cepat. Tersedia Senin - Jumat, 08:00 - 17:00 WIB.',
                'link'        => 'https://wa.me/628123456789', // Ganti dengan nomor WhatsApp Anda
                'icon_class'  => 'bi bi-whatsapp',
                'is_active'   => true,
                'show_in_contact_page' => false,
            ],
            // Email
            [
                'contact_type' => 'email',
                'title'       => 'Email Support',
                'description' => 'Kirim email untuk pertanyaan detail. Kami akan balas dalam 1x24 jam.',
                'link'        => 'mailto:support@meatmap.id', // Ganti dengan email Anda
                'icon_class'  => 'bi bi-envelope',
                'is_active'   => true,
                'show_in_contact_page' => true,
            ],
            // Telepon
            [
                'contact_type' => 'phone',
                'title'       => 'Phone Support',
                'description' => 'Hubungi kami langsung untuk bantuan mendesak.',
                'link'        => 'tel:+628112345678', // Ganti dengan nomor telepon Anda
                'icon_class'  => 'bi bi-telephone',
                'is_active'   => true,
                'show_in_contact_page' => true,
            ],
            // Instagram
            [
                'contact_type' => 'instagram',
                'title'       => 'Instagram',
                'description' => 'Ikuti kami untuk tips perjalanan dan promosi menarik.',
                'link'        => 'https://www.instagram.com/meatmap.id', // Ganti dengan username Instagram Anda
                'icon_class'  => 'bi bi-instagram',
                'is_active'   => true,
                'show_in_contact_page' => false,
            ],
            // Facebook
            [
                'contact_type' => 'facebook',
                'title'       => 'Facebook',
                'description' => 'Bergabung dengan komunitas traveler MeatMap di Facebook.',
                'link'        => 'https://www.facebook.com/meatmap.id', // Ganti dengan halaman Facebook Anda
                'icon_class'  => 'bi bi-facebook',
                'is_active'   => true,
                'show_in_contact_page' => false,
            ],
            // Twitter / X
            [
                'contact_type' => 'twitter',
                'title'       => 'X (Twitter)',
                'description' => 'Dapatkan update terbaru seputar e-book dan destinasi.',
                'link'        => 'https://twitter.com/meatmap_id', // Ganti dengan handle X/Twitter Anda
                'icon_class'  => 'bi bi-twitter-x',
                'is_active'   => true,
                'show_in_contact_page' => true,
            ],
            // Alamat (Opsional)
            [
                'contact_type' => 'address',
                'title'       => 'Our Office',
                'description' => 'Kunjungi kantor kami untuk konsultasi langsung.',
                'link'        => '#', // Bisa link ke Google Maps
                'icon_class'  => 'bi bi-geo-alt',
                'is_active'   => true,
                'show_in_contact_page' => false,
            ],
        ];

        ContactInfo::insert($contacts);
    }
}
