<?php

namespace Database\Seeders;

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
            [
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
                'mayar_payment_link' => $baseDomain . '/pl/starter-daily-30788', // ← ganti xxx
            ],
            [
                'name' => 'Menengah - Weekly',
                'slug' => 'menengah-weekly',
                'description' => 'Ideal for avid travelers who want new content every month.',
                'price' => 66000,
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
                'name' => 'Monthly Explorer - Monthly',
                'slug' => 'monthly-explorer-monthly-25465',
                'description' => 'Best value for dedicated explorers. Save big with an annual plan.',
                'price' => 99000,
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
                'name' => 'Yearly Voyager',
                'slug' => 'yearly-voyager-66003',
                'description' => 'Tailored solutions for teams and travel agencies.',
                'price' => 399000,
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
        ];

        foreach ($plans as $planData) {
            $planData['id'] = Str::uuid();
            SubscriptionPlan::create($planData);
        }

        $this->command->info('✅ Subscription Plans seeded with Mayar payment links!');
    }
}
