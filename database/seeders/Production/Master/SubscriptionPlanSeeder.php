<?php

namespace Database\Seeders\Production\Master;

use App\Models\SubscriptionPlan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class SubscriptionPlanSeeder extends Seeder
{
    public function run(): void
    {
        $baseDomain = 'https://meat-map.myr.id';

        $plans = [
            // === PLAN PRODUKSI ===
            [
                'id' => 'starter-daily-30788', // ✅ ID tetap
                'name' => 'Starter - Daily',
                'slug' => 'starter-daily-30788',
                'description' => 'Perfect for trying out our platform with limited access.',
                'price' => 1000,
                'price_description' => 'Untuk pemula',
                'duration_days' => 1,
                'features' => [
                    'Access to 5 Free Ebooks',
                    'Community Support',
                ],
                'button_text' => 'Get Started',
                'is_featured' => false,
                'sort_order' => 1,
                'is_active' => true,
                'category_subscription' => 'harian',
                'mayar_payment_link' => $baseDomain . '/pl/starter-daily-30788',
            ],
            [
                'id' => 'menengah-weekly-62068',
                'name' => 'Menengah - Weekly',
                'slug' => 'menengah-weekly',
                'description' => 'Ideal for avid travelers who want new content every month.',
                'price' => 1000,
                'price_description' => 'Per Week',
                'duration_days' => 7,
                'features' => [
                    'Unlimited Ebooks Access',
                    'New Guides Monthly',
                    'Priority Email Support',
                    'Offline Downloads',
                ],
                'button_text' => 'Subscribe Now',
                'is_featured' => false,
                'sort_order' => 2,
                'is_active' => true,
                'category_subscription' => 'mingguan',
                'mayar_payment_link' => $baseDomain . '/pl/menengah-weekly-62068',
            ],
            [
                'id' => 'monthly-explorer-monthly-25465',
                'name' => 'Monthly Explorer - Monthly',
                'slug' => 'monthly-explorer-monthly-25465',
                'description' => 'Best value for dedicated explorers. Save big with an annual plan.',
                'price' => 1000,
                'price_description' => 'Per Month',
                'duration_days' => 30,
                'features' => [
                    'Everything in Monthly',
                    'Exclusive Early Access',
                    '24/7 Priority Support',
                    'Bonus Travel Itineraries',
                ],
                'button_text' => 'Go Voyager',
                'is_featured' => true,
                'sort_order' => 3,
                'is_active' => true,
                'category_subscription' => 'bulanan',
                'mayar_payment_link' => $baseDomain . '/pl/monthly-explorer-monthly-25465',
            ],
            [
                'id' => 'yearly-voyager-66003',
                'name' => 'Yearly Voyager',
                'slug' => 'yearly-voyager-66003',
                'description' => 'Tailored solutions for teams and travel agencies.',
                'price' => 1000,
                'price_description' => 'Per Year',
                'duration_days' => 365,
                'features' => [
                    'Everything in Voyager',
                    'Team Collaboration Tools',
                    'Dedicated Account Manager',
                    'Custom Content Requests',
                ],
                'button_text' => 'Contact Sales',
                'is_featured' => false,
                'sort_order' => 4,
                'is_active' => true,
                'category_subscription' => 'tahunan',
                'mayar_payment_link' => $baseDomain . '/pl/yearly-voyager-66003',
            ],

            // === PLAN SIMULASI (AMAN UNTUK PRODUCTION) ===
            [
                'id' => 'harian-untuk-simulasi', // ✅ ID tetap
                'name' => 'Harian (Untuk Simulasi)',
                'slug' => 'harian-untuk-simulasi',
                'description' => 'Untuk simulasi, anda dapat subscribe paket harian ini. Dengan memilih pembayaran e-wallet -> shopeepay, lalu saat muncul qr code nya, anda klik QR CODE nya.',
                'price' => 2000,
                'price_description' => 'Untuk Simulasi',
                'duration_days' => 1,
                'features' => [
                    'Access to 5 Free Ebooks',
                    'Community Support',
                ],
                'button_text' => 'Subscribe Simulasi',
                'is_featured' => false,
                'sort_order' => 5, // urutan terakhir
                'is_active' => true,
                'category_subscription' => 'harian',
                'mayar_payment_link' => 'https://meat-map-99805.mayar.shop/pl/harian-untuk-simulasi',
            ],
            [
                'id' => 'mingguan-untuk-simulasi',
                'name' => 'Mingguan (Untuk Simulasi)',
                'slug' => 'mingguan-untuk-simulasi',
                'description' => 'Untuk simulasi, anda dapat subscribe paket harian ini. Dengan memilih pembayaran e-wallet -> shopeepay, lalu saat muncul qr code nya, anda klik QR CODE nya.',
                'price' => 10000,
                'price_description' => 'Untuk Simulasi - Mingguan',
                'duration_days' => 7,
                'features' => [
                    'Access to 5 Free Ebooks',
                    'Community Support',
                ],
                'button_text' => 'Subscribe Simulasi',
                'is_featured' => false,
                'sort_order' => 6,
                'is_active' => true,
                'category_subscription' => 'mingguan',
                'mayar_payment_link' => 'https://meat-map-99805.mayar.shop/pl/mingguan-untuk-simulasi',
            ],
        ];

        foreach ($plans as $planData) {
            // ✅ Generate UUID untuk id
            $planData['id'] = (string) Str::uuid();

            SubscriptionPlan::updateOrCreate(
                ['slug' => $planData['slug']], // Cari berdasarkan slug
                $planData
            );
        }

        $this->command->info('✅ Subscription Plans seeded safely with updateOrCreate!');
    }
}
