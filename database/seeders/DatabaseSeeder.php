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
            // ================================================
            // 1. DATA DASAR (Tidak ada ketergantungan)
            // ================================================
            RoleSeeder::class,                  // Membuat role (admin, creator, member)
            CategorySeeder::class,              // Membuat kategori (kuliner, wisata-alam, dll)
            CitySeeder::class,                  // Membuat kota (surabaya, jakarta, dll)
            CollectionSeeder::class,            // Membuat koleksi (best-seller, featured, dll)
            SubscriptionPlanSeeder::class,      // Membuat paket berlangganan (basic, premium)
            SubscriptionPromoSeeder::class,     // Membuat promo subscription
            
            // ================================================
            // 2. PERMISSIONS & SYSTEM SETTINGS
            // ================================================
            PanelAccessPermissionSeeder::class, // Panel access permissions untuk creators & admins
            AdminPermissionsSeeder::class,      // Membuat permissions untuk admin panel (new system)
            SystemSettingSeeder::class,         // Membuat system settings
            
            // ================================================
            // 3. DATA PENGGUNA (Bergantung pada RoleSeeder)
            // ================================================
            CreatorSeeder::class,               // Membuat creator users
            UserSeeder::class,                  // Membuat user (creator, member)
            DefaultAdminSeeder::class,          // Membuat user admin khusus (superadmin)

            // ================================================
            // 4. DATA KONTEN UTAMA (Bergantung pada data dasar & pengguna)
            // ================================================
            EbookSeeder::class,                 // Membuat data ebook (BUTUH: Category, City, User)
            BlogSeeder::class,                  // Membuat data blog (BUTUH: Category, User)

            // ================================================
            // 5. TABEL HUBUNGAN / PIVOT (Bergantung pada data konten)
            // ================================================
            EbookCategorySeeder::class,         // Menghubungkan ebook ke kategori (BUTUH: Ebook, Category)
            CollectionEbookSeeder::class,       // Menghubungkan ebook ke koleksi (BUTUH: Ebook, Collection)
            SubscriptionSeeder::class,          // Menghubungkan user ke paket berlangganan (BUTUH: User, Plan)

            // ================================================
            // 6. WEBSITE CONTENT & UI
            // ================================================
            LandingPageSectionsSeeder::class,   // Membuat landing page sections
            BannerSeeder::class,                // Membuat banner di homepage
            PricingBannerSeeder::class,         // Membuat pricing banners
            PricingBenefitSeeder::class,        // Membuat pricing benefits (about us)
            AboutUsSectionsSeeder::class,       // Membuat about us sections
            ContactInfoSeeder::class,           // Membuat contact info
            FaqSeeder::class,                   // Membuat FAQ
            SiteSettingsSeeder::class,          // Membuat site settings (logo, etc)
            FaqPageSeeder::class,
            PolicyPageSeeder::class,
            PaymentSeeder::class,              // Membuat data pembayaran contoh (BUTUH: User, Subscription)
        ]);
    }
}
