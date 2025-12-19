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
        $plans = [
            [
                'name' => 'Starter',
                'slug' => 'starter',
                'description' => 'Perfect for trying out our platform with limited access.',
                'price' => 20000,
                'price_description' => 'Always Free',
                'duration_days' => 365,
                'features' => [
                    'Access to 5 Free Ebooks',
                    'Community Support',
                ],
                'button_text' => 'Get Started',
                'is_featured' => false,
                'sort_order' => 1,
                'is_active' => true,
                'category_subscription' => 'harian',
            ],
            [
                'name' => 'Monthly Explorer',
                'slug' => 'monthly-explorer', // <-- Slug yang dibutuhkan
                'description' => 'Ideal for avid travelers who want new content every month.',
                'price' => 66000,
                'price_description' => 'Per Month',
                'duration_days' => 30,
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
            ],
            [
                'name' => 'Yearly Voyager',
                'slug' => 'yearly-voyager', // <-- Slug yang dibutuhkan
                'description' => 'Best value for dedicated explorers. Save big with an annual plan.',
                'price' => 99000,
                'price_description' => 'Per Month',
                'duration_days' => 365,
                'features' => [
                    'Everything in Monthly',
                    'Exclusive Early Access',
                    '24/7 Priority Support',
                    'Bonus Travel Itineraries',
                ],
                'button_text' => 'Go Voyager',
                'is_featured' => true, // Jadikan yang ini unggulan
                'sort_order' => 3,
                'is_active' => true,
                'category_subscription' => 'bulanan',
            ],
            [
                'name' => 'Business',
                'slug' => 'business',
                'description' => 'Tailored solutions for teams and travel agencies.',
                'price' => 200000,
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
            ],
        ];

        foreach ($plans as $planData) {
            $planData['id'] = Str::uuid();
            SubscriptionPlan::create($planData);
        }

        $this->command->info('Subscription Plans created successfully!');
    }
}
