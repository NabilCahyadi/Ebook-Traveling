<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubscriptionPromoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $promos = [
            // 1. Welcome promo for new users - 50% off
            [
                'promo' => [
                    'name' => 'Welcome50 - New User Discount',
                    'code' => 'WELCOME50',
                    'description' => '50% discount for new users on their first Premium subscription',
                    'type' => 'percentage',
                    'value' => 50,
                    'start_date' => now(),
                    'end_date' => now()->addMonths(6),
                    'max_usage' => null, // unlimited
                    'max_usage_per_user' => 1,
                    'is_active' => true,
                ],
                'conditions' => [
                    ['condition_type' => 'new_user', 'condition_value' => null],
                    ['condition_type' => 'first_subscription', 'condition_value' => null],
                    ['condition_type' => 'subscription_type', 'condition_value' => 'Premium,Pro'],
                ],
            ],

            // 2. First time subscriber - $5 off
            [
                'promo' => [
                    'name' => 'FirstTime5 - First Subscription Discount',
                    'code' => 'FIRSTTIME5',
                    'description' => '$5 off for first-time subscribers on any plan',
                    'type' => 'fixed_amount',
                    'value' => 5.00,
                    'start_date' => now(),
                    'end_date' => now()->addYear(),
                    'max_usage' => 1000,
                    'max_usage_per_user' => 1,
                    'is_active' => true,
                ],
                'conditions' => [
                    ['condition_type' => 'first_subscription', 'condition_value' => null],
                    ['condition_type' => 'min_price', 'condition_value' => '9.99'],
                ],
            ],

            // 3. Free trial for Premium plan
            [
                'promo' => [
                    'name' => 'FreeTrial30 - 30 Days Free Trial',
                    'code' => 'FREETRIAL30',
                    'description' => '30 days free trial for Premium subscription',
                    'type' => 'free_trial',
                    'value' => 30, // days
                    'start_date' => now(),
                    'end_date' => now()->addMonths(3),
                    'max_usage' => 500,
                    'max_usage_per_user' => 1,
                    'is_active' => true,
                ],
                'conditions' => [
                    ['condition_type' => 'subscription_type', 'condition_value' => 'Premium'],
                    ['condition_type' => 'first_subscription', 'condition_value' => null],
                ],
            ],

            // 4. Holiday special - 70% off
            [
                'promo' => [
                    'name' => 'HolidaySale70 - Holiday Special',
                    'code' => 'HOLIDAY70',
                    'description' => 'Limited time: 70% off on all subscription plans',
                    'type' => 'percentage',
                    'value' => 70,
                    'start_date' => now(),
                    'end_date' => now()->addDays(30),
                    'max_usage' => 100,
                    'max_usage_per_user' => 1,
                    'is_active' => true,
                ],
                'conditions' => [
                    ['condition_type' => 'min_price', 'condition_value' => '9.99'],
                ],
            ],

            // 5. Premium Pro upgrade - $10 off
            [
                'promo' => [
                    'name' => 'ProUpgrade10 - Pro Plan Discount',
                    'code' => 'PROUPGRADE10',
                    'description' => '$10 off when upgrading to Pro subscription',
                    'type' => 'fixed_amount',
                    'value' => 10.00,
                    'start_date' => now(),
                    'end_date' => now()->addMonths(12),
                    'max_usage' => null,
                    'max_usage_per_user' => 1,
                    'is_active' => true,
                ],
                'conditions' => [
                    ['condition_type' => 'subscription_type', 'condition_value' => 'Pro'],
                ],
            ],

            // 6. Auto-apply new user promo (no code needed)
            [
                'promo' => [
                    'name' => 'Auto NewUser 25% - Automatic Discount',
                    'code' => null, // auto-apply, no code needed
                    'description' => 'Automatic 25% discount for all new users (within 7 days)',
                    'type' => 'percentage',
                    'value' => 25,
                    'start_date' => now(),
                    'end_date' => now()->addYear(),
                    'max_usage' => null,
                    'max_usage_per_user' => 1,
                    'is_active' => false, // start inactive for manual activation
                ],
                'conditions' => [
                    ['condition_type' => 'new_user', 'condition_value' => null],
                ],
            ],
        ];

        foreach ($promos as $data) {
            // Map new type/value to old discount_type/discount_value for backward compatibility
            $discountType = $data['promo']['type'] === 'fixed_amount' ? 'fixed' : 'percentage';
            $discountValue = $data['promo']['type'] === 'free_trial' ? 0 : $data['promo']['value'];

            $promo = \App\Models\Promo::create(array_merge($data['promo'], [
                'discount_type' => $discountType,
                'discount_value' => $discountValue,
                'min_purchase_amount' => 0,
            ]));

            foreach ($data['conditions'] as $condition) {
                \App\Models\PromoCondition::create([
                    'promo_id' => $promo->id,
                    'condition_type' => $condition['condition_type'],
                    'condition_value' => $condition['condition_value'],
                ]);
            }
        }

        $this->command->info('✅ ' . count($promos) . ' subscription promos created successfully!');
        $this->command->info('🎫 Promo codes: WELCOME50, FIRSTTIME5, FREETRIAL30, HOLIDAY70, PROUPGRADE10');
    }
}
