<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([

            // 1. DATA DASAR (Tidak ada ketergantungan)
            // Seeder ini harus dijalankan pertama karena data lain akan membutuhkannya.
            RoleSeeder::class,           // Membuat role (admin, creator, member)
            CategorySeeder::class,       // Membuat kategori (kuliner, wisata-alam, dll)
            CitySeeder::class,           // Membuat kota (surabaya, jakarta, dll)
            CollectionSeeder::class,     // Membuat koleksi (best-seller, featured, dll)
            SubscriptionPlanSeeder::class, // Membuat paket berlangganan (basic, premium)
            SubscriptionPromoSeeder::class,
            
            // 2. PERMISSIONS & SYSTEM SETTINGS
            PermissionSeeder::class,     // Membuat permissions untuk role-based access
            AdminPermissionSeeder::class, // Membuat permissions untuk admin panel
            SystemSettingSeeder::class,  // Membuat system settings
            PanelAccessPermissionSeeder::class, // Panel access permissions
            
            // 3. DATA PENGGUNA (Bergantung pada RoleSeeder)
            // Membuat pengguna setelah role tersedia.
            CreatorSeeder::class,
            UserSeeder::class,           // Membuat user (creator, member)
            DefaultAdminSeeder::class,          // Membuat user admin khusus

            // 4. DATA KONTEN UTAMA (Bergantung pada data dasar & pengguna)
            // Membuat konten setelah kategori, kota, dan creator tersedia.
            EbookSeeder::class,         // Membuat data ebook (BUTUH: Category, City, User)
            BlogSeeder::class,           // Membuat data blog (BUTUH: Category, User)

            // 5. TABEL HUBUNGAN / PIVOT (Bergantung pada data konten)
            // Menghubungkan konten setelah konten itu sendiri dibuat.
            EbookCategorySeeder::class, // Menghubungkan ebook ke kategori (BUTUH: Ebook, Category)
            CollectionEbookSeeder::class, // Menghubungkan ebook ke koleksi (BUTUH: Ebook, Collection)

            // 6. LANDING PAGE & UI
            LandingPageSectionsSeeder::class, // Membuat landing page sections

            // 7. DATA TAMBAHAN & LAINNYA
            // Seeder yang tidak terlalu kritis atau bergantung pada data sebelumnya.
            BannerSeeder::class,         // Membuat banner di homepage
            SubscriptionSeeder::class,   // Menghubungkan user ke paket berlangganan (BUTUH: User, Plan)
            PremiumUserSeeder::class,   // Membuat user premium (BUTUH: User, Subscription)

            PricingBannerSeeder::class,
            PricingBenefitSeeder::class,
            FaqSeeder::class,
        ]);
    }
}
