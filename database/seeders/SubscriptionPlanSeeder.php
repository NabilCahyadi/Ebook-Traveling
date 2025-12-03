<?php

namespace Database\Seeders;

use App\Models\SubscriptionPlan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SubscriptionPlanSeeder extends Seeder
{
    public function run(): void
    {
        $plans = [
            [
                'name' => 'Basic Plan',
                'description' => 'Perfect for casual readers and occasional travelers. Access to essential travel guides with basic features.',
                'price_monthly' => 9.99,
                
                'price_annual' => 99.99,
                'duration_days' => 30,
                'max_books' => 50,
                'features' => [
                    'Access to 100+ travel guides',
                    'Basic customer support',
                    'Mobile app access',
                    'Regular content updates',
                    'Email support',
                    '1 device at a time'
                ],
                'is_active' => true,
                'order_index' => 0,
            ],
            [
                'name' => 'Premium Plan',
                'description' => 'For avid travelers and frequent readers. Get access to exclusive city guides and advanced features.',
                'price_monthly' => 19.99,
                'price_annual' => 199.99,
                'duration_days' => 30,
                'max_books' => 200,
                'features' => [
                    'Access to 500+ travel guides',
                    'Priority customer support',
                    'Offline reading',
                    'Exclusive city guides',
                    'Travel itinerary planner',
                    'Download up to 50 guides',
                    '3 devices at a time',
                    'Advanced search filters'
                ],
                'is_active' => true,
                'order_index' => 1,
            ],
            [
                'name' => 'Pro Plan',
                'description' => 'Ultimate travel experience with exclusive benefits. Perfect for travel enthusiasts and professionals.',
                'price_monthly' => 29.99,
                'price_annual' => 299.99,
                'duration_days' => 30,
                'max_books' => 999, // Unlimited
                'features' => [
                    'Unlimited travel guides',
                    '24/7 premium support',
                    'Offline download all guides',
                    'Exclusive destination content',
                    'Early access to new guides',
                    'Personal travel consultant',
                    'Custom travel plans',
                    '5 devices at a time',
                    'Priority feature requests',
                    'Monthly newsletter with tips'
                ],
                'is_active' => true,
                'order_index' => 2,
            ],
            // Optional: Free Trial Plan
            [
                'name' => 'Free Trial',
                'description' => 'Try our service for free with limited access to premium features.',
                'price_monthly' => 0.00,
                'price_annual' => 0.00,
                'duration_days' => 7,
                'max_books' => 10,
                'features' => [
                    'Access to 10 travel guides',
                    'Basic customer support',
                    'Mobile app access',
                    '7-day free trial'
                ],
                'is_active' => true,
                'order_index' => 3,
            ],
            // Optional: Annual Saver Plan
            [
                'name' => 'Annual Saver',
                'description' => 'Save 25% with annual billing. Perfect for long-term travelers and book enthusiasts.',
                'price_monthly' => 24.99,
                'price_annual' => 249.99,
                'duration_days' => 365,
                'max_books' => 300,
                'features' => [
                    'Access to 800+ travel guides',
                    'Priority customer support',
                    'Offline reading all guides',
                    'Annual travel report',
                    'Discount on partner services',
                    '4 devices at a time',
                    'Free travel checklist'
                ],
                'is_active' => true,
                'order_index' => 4,
            ]
        ];

        foreach ($plans as $plan) {
            SubscriptionPlan::create([
                'id' => Str::uuid(),
                'name' => $plan['name'],
                'description' => $plan['description'],
                'price_monthly' => $plan['price_monthly'],
                'price_annual' => $plan['price_annual'],
                'duration_days' => $plan['duration_days'],
                'features' => json_encode($plan['features']),
                'max_books' => $plan['max_books'],
                'is_active' => $plan['is_active'],
                'order_index' => $plan['order_index'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $this->command->info('✅ Subscription plans seeded successfully!');
        $this->command->info('💰 Total: ' . count($plans) . ' subscription plans created');
    }
}
