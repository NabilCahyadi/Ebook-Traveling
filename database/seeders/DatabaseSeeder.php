<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

// Production Seeders - Core
use Database\Seeders\Production\Core\RoleSeeder;
use Database\Seeders\Production\Core\PanelAccessPermissionSeeder;
use Database\Seeders\Production\Core\AdminPermissionsSeeder;
use Database\Seeders\Production\Core\SystemSettingSeeder;
use Database\Seeders\Production\Core\DefaultAdminSeeder;

// Production Seeders - Master Data
use Database\Seeders\Production\Master\CategorySeeder;
use Database\Seeders\Production\Master\BlogCategorySeeder;
use Database\Seeders\Production\Master\CitySeeder;
use Database\Seeders\Production\Master\CollectionSeeder;
use Database\Seeders\Production\Master\SubscriptionPlanSeeder;
use Database\Seeders\Production\Master\SubscriptionPromoSeeder;

// Production Seeders - Website Content
use Database\Seeders\Production\Website\LandingPageSectionsSeeder;
use Database\Seeders\Production\Website\BannerSeeder;
use Database\Seeders\Production\Website\PricingBannerSeeder;
use Database\Seeders\Production\Website\PricingBenefitSeeder;
use Database\Seeders\Production\Website\AboutUsSectionsSeeder;
use Database\Seeders\Production\Website\ContactInfoSeeder;
use Database\Seeders\Production\Website\SiteSettingsSeeder;
use Database\Seeders\Production\Website\FaqSeeder;
use Database\Seeders\Production\Website\FaqPageSeeder;
use Database\Seeders\Production\Website\FaqPricingSeeder;
use Database\Seeders\Production\Website\PolicyPageSeeder;

// Development Seeders - Fake/Test Data
use Database\Seeders\Development\CreatorSeeder;
use Database\Seeders\Development\UserSeeder;
use Database\Seeders\Development\EbookSeeder;
use Database\Seeders\Development\BlogSeeder;
use Database\Seeders\Development\EbookCategorySeeder;
use Database\Seeders\Development\CollectionEbookSeeder;
use Database\Seeders\Development\SubscriptionSeeder;
use Database\Seeders\Development\PaymentSeeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     * 
     * WARNING: This seeder includes DEVELOPMENT/FAKE data.
     * For production, use: php artisan db:seed --class=ProductionSeeder
     */
    public function run(): void
    {
        $this->call([
            // ================================================
            // 1. DATA DASAR (Tidak ada ketergantungan)
            // Folder: database/seeders/Production/Core/ & Master/
            // ================================================
            RoleSeeder::class,                  // Membuat role (admin, creator, member)
            CategorySeeder::class,              // Membuat kategori ebook
            BlogCategorySeeder::class,          // Membuat kategori blog
            CitySeeder::class,                  // Membuat kota (surabaya, jakarta, dll)
            CollectionSeeder::class,            // Membuat koleksi (best-seller, featured, dll)
            SubscriptionPlanSeeder::class,      // Membuat paket berlangganan (basic, premium)
            SubscriptionPromoSeeder::class,     // Membuat promo subscription
            
            // ================================================
            // 2. PERMISSIONS & SYSTEM SETTINGS
            // Folder: database/seeders/Production/Core/
            // ================================================
            PanelAccessPermissionSeeder::class, // Panel access permissions untuk creators & admins
            AdminPermissionsSeeder::class,      // Membuat permissions untuk admin panel (new system)
            SystemSettingSeeder::class,         // Membuat system settings
            
            // ================================================
            // 3. DATA PENGGUNA (Bergantung pada RoleSeeder)
            // Folder: database/seeders/Production/Core/ & Development/
            // ================================================
            CreatorSeeder::class,               // [DEV] Membuat creator users
            UserSeeder::class,                  // [DEV] Membuat user (creator, member)
            DefaultAdminSeeder::class,          // [PROD] Membuat user admin khusus (superadmin)

            // ================================================
            // 4. DATA KONTEN UTAMA (Bergantung pada data dasar & pengguna)
            // Folder: database/seeders/Development/
            // ================================================
            EbookSeeder::class,                 // [DEV] Membuat data ebook (BUTUH: Category, City, User)
            BlogSeeder::class,                  // [DEV] Membuat data blog (BUTUH: Category, User)

            // ================================================
            // 5. TABEL HUBUNGAN / PIVOT (Bergantung pada data konten)
            // Folder: database/seeders/Development/
            // ================================================
            EbookCategorySeeder::class,         // [DEV] Menghubungkan ebook ke kategori
            CollectionEbookSeeder::class,       // [DEV] Menghubungkan ebook ke koleksi
            SubscriptionSeeder::class,          // [DEV] Menghubungkan user ke paket berlangganan

            // ================================================
            // 6. WEBSITE CONTENT & UI
            // Folder: database/seeders/Production/Website/
            // ================================================
            LandingPageSectionsSeeder::class,   // Membuat landing page sections
            BannerSeeder::class,                // Membuat banner di homepage
            PricingBannerSeeder::class,         // Membuat pricing banners
            PricingBenefitSeeder::class,        // Membuat pricing benefits (about us)
            AboutUsSectionsSeeder::class,       // Membuat about us sections
            ContactInfoSeeder::class,           // Membuat contact info
            FaqSeeder::class,                   // Membuat FAQ
            SiteSettingsSeeder::class,          // Membuat site settings (logo, etc)
            FaqPageSeeder::class,               // Membuat FAQ page content
            FaqPricingSeeder::class,            // Membuat FAQ pricing
            PolicyPageSeeder::class,            // Membuat policy pages
            PaymentSeeder::class,               // [DEV] Membuat data pembayaran contoh
        ]);
    }
}

