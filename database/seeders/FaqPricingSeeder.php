<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Faq;
use Illuminate\Support\Str;

class FaqPricingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faqs = [
            [
                'question' => 'What does the subscription include?',
                'answer' => 'The subscription includes unlimited access to all travel eBooks, latest destination guides every month, ability to download eBooks for offline reading, regular content updates, exclusive travel tips, and priority customer support 24/7.',
                'order_index' => 1,
                'is_active' => true
            ],
            [
                'question' => 'Can I cancel my subscription anytime?',
                'answer' => 'Yes, you can cancel your subscription at any time via the "Billing" page in your account. The cancellation will be effective at the end of the current billing period. There are no cancellation fees.',
                'order_index' => 2,
                'is_active' => true
            ],
            [
                'question' => 'Is there an annual subscription with a discount?',
                'answer' => 'Yes, we offer an annual subscription plan with a discount of up to 30% compared to the monthly subscription. The annual package provides full access for 12 months with a single payment.',
                'order_index' => 3,
                'is_active' => true
            ],
            [
                'question' => 'What payment methods are accepted?',
                'answer' => 'We accept various payment methods including Bank Transfer (BCA, BNI, Mandiri, BRI), E-Wallet (Gopay, OVO, Dana, LinkAja), Credit Cards (Visa, Mastercard, JCB), and QRIS payment via QR Code.',
                'order_index' => 4,
                'is_active' => true
            ],
            [
                'question' => 'Is there a free trial available?',
                'answer' => 'Yes, we offer a 7-day free trial for new users. You can explore all features and access our complete eBook collection during the trial period. No credit card required to start your trial.',
                'order_index' => 5,
                'is_active' => true
            ],
            [
                'question' => 'How do I upgrade or downgrade my plan?',
                'answer' => 'You can upgrade or downgrade your plan anytime through your account settings. Changes will be prorated and reflected in your next billing cycle. If you upgrade, you\'ll get immediate access to new features.',
                'order_index' => 6,
                'is_active' => true
            ],
            [
                'question' => 'What happens if my payment fails?',
                'answer' => 'If your payment fails, your subscription will be temporarily suspended. You\'ll receive an email notification with instructions to update your payment method. Your account will be reactivated once the payment is successful.',
                'order_index' => 7,
                'is_active' => true
            ],
            [
                'question' => 'Can I share my subscription with others?',
                'answer' => 'Subscriptions are for individual use only. However, our Family Plan allows you to share access with up to 5 family members at a discounted rate. Contact our support team for more information about the Family Plan.',
                'order_index' => 8,
                'is_active' => true
            ]
        ];

        foreach ($faqs as $faq) {
            Faq::create([
                'id' => Str::uuid(),
                'question' => $faq['question'],
                'answer' => $faq['answer'],
                'category' => 'pricing',
                'order_index' => $faq['order_index'],
                'is_active' => $faq['is_active']
            ]);
        }

        $this->command->info('FAQ Pricing seeded successfully!');
    }
}
