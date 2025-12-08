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
                'slug' => 'basic-plan',
                'description' => 'Perfect for casual readers and occasional travelers. Access to essential travel guides with basic features.',
                'price' => 9.99,
                'duration_days' => 30,
                'cover_image' => 'images/banner-subs-1.webp',
                'features' => json_encode([
                    'Access to 100+ travel guides',
                    'Basic customer support',
                    'Mobile app access',
                    'Regular content updates',
                    'Email support',
                    '1 device at a time'
                ]),
                'is_active' => true,
            ],
            [
                'name' => 'Premium Plan',
                'slug' => 'premium-plan',
                'description' => 'For avid travelers and frequent readers. Get access to exclusive city guides and advanced features.',
                'price' => 19.99,
                'duration_days' => 30,
                'cover_image' => 'images/banner-subs-2.webp',
                'features' => json_encode([
                    'Access to 500+ travel guides',
                    'Priority customer support',
                    'Offline reading',
                    'Exclusive city guides',
                    'Travel itinerary planner',
                    'Download up to 50 guides',
                    '3 devices at a time',
                    'Advanced search filters'
                ]),
                'is_active' => true,
            ],
            [
                'name' => 'Pro Plan',
                'slug' => 'pro-plan',
                'description' => 'Ultimate travel experience with exclusive benefits. Perfect for travel enthusiasts and professionals.',
                'price' => 29.99,
                'duration_days' => 30,
                'cover_image' => 'images/banner-subs-3.webp',
                'features' => json_encode([
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
                ]),
                'is_active' => true,
            ],
        ];

        foreach ($plans as $plan) {
            SubscriptionPlan::create($plan);
        }

        $this->command->info('✅ Subscription plans seeded successfully!');
        $this->command->info('💰 Total: ' . count($plans) . ' subscription plans created');
    }
}
