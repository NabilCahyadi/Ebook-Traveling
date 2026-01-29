<?php

namespace Database\Seeders;

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

class ProductionSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database for PRODUCTION environment.
     * 
     * This seeder only includes essential data needed for the application to function.
     * It does NOT include any fake/dummy data (users, ebooks, blogs, etc.)
     * 
     * Usage: php artisan db:seed --class=ProductionSeeder
     */
    public function run(): void
    {
        $this->command->info('');
        $this->command->info('╔════════════════════════════════════════════════════════════╗');
        $this->command->info('║           PRODUCTION DATABASE SEEDER                       ║');
        $this->command->info('║                                                            ║');
        $this->command->info('║  This seeder will create essential data only.              ║');
        $this->command->info('║  NO fake users, ebooks, or blogs will be created.          ║');
        $this->command->info('╚════════════════════════════════════════════════════════════╝');
        $this->command->info('');

        $this->call([
            // ================================================
            // TIER 1: CORE - Data Fundamental (Harus Paling Awal)
            // Folder: database/seeders/Production/Core/
            // ================================================
            RoleSeeder::class,                  // Role user (Reader, Creator)
            PanelAccessPermissionSeeder::class, // Panel access permissions
            AdminPermissionsSeeder::class,      // Permission system untuk admin panel
            SystemSettingSeeder::class,         // System settings
            DefaultAdminSeeder::class,          // Akun admin & superadmin

            // ================================================
            // TIER 2: MASTER - Data Master
            // Folder: database/seeders/Production/Master/
            // ================================================
            CategorySeeder::class,              // Kategori ebook
            BlogCategorySeeder::class,          // Kategori blog
            CitySeeder::class,                  // Data kota
            CollectionSeeder::class,            // Koleksi ebook (best-seller, featured, dll)

            // ================================================
            // TIER 3: MONETISASI
            // Folder: database/seeders/Production/Master/
            // ================================================
            SubscriptionPlanSeeder::class,      // Paket berlangganan (PENTING!)
            SubscriptionPromoSeeder::class,     // Promo subscription (opsional, bisa di-comment jika tidak ada promo)

            // ================================================
            // TIER 4: WEBSITE - Konten Website (UI/UX)
            // Folder: database/seeders/Production/Website/
            // ================================================
            LandingPageSectionsSeeder::class,   // Konten landing page
            BannerSeeder::class,                // Banner homepage
            PricingBannerSeeder::class,         // Banner pricing page
            PricingBenefitSeeder::class,        // Benefit pricing/about us
            AboutUsSectionsSeeder::class,       // About us sections
            ContactInfoSeeder::class,           // Info kontak
            SiteSettingsSeeder::class,          // Site settings (logo, favicon, dll)

            // ================================================
            // TIER 5: FAQ & POLICIES
            // Folder: database/seeders/Production/Website/
            // ================================================
            FaqSeeder::class,                   // FAQ umum
            FaqPageSeeder::class,               // FAQ page content
            FaqPricingSeeder::class,            // FAQ pricing
            PolicyPageSeeder::class,            // Privacy policy, terms, dll
        ]);

        $this->command->info('');
        $this->command->info('╔════════════════════════════════════════════════════════════╗');
        $this->command->info('║           ✅ PRODUCTION SEEDING COMPLETED!                 ║');
        $this->command->info('╠════════════════════════════════════════════════════════════╣');
        $this->command->info('║                                                            ║');
        $this->command->info('║  Next steps:                                               ║');
        $this->command->info('║  1. Login as superadmin: superadmin@gmail.com              ║');
        $this->command->info('║  2. Change the default password immediately!               ║');
        $this->command->info('║  3. Configure site settings from admin panel               ║');
        $this->command->info('║  4. Update Mayar payment links if needed                   ║');
        $this->command->info('║                                                            ║');
        $this->command->info('╚════════════════════════════════════════════════════════════╝');
        $this->command->info('');
    }
}
