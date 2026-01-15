<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Faq;
use Illuminate\Support\Str;

// seeder faqs untuk di pricing page
class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faqs = [
            [
                'question' => 'What does subscription include?',
                'answer' => 'Your subscription grants unlimited access to our full library of city guides, downloadable offline copies, regular content updates, and priority support for troubleshooting and recommendations.',
                'category' => 'pricing',
                'order_index' => 1,
            ],
            [
                'question' => 'Can I cancel anytime and get a refund?',
                'answer' => 'You can cancel at any time. Refund eligibility depends on your plan and billing cycle — please review our refund policy in terms or contact support for assistance with billing issues.',
                'category' => 'pricing',
                'order_index' => 2,
            ],
            [
                'question' => 'Will guides work offline after download?',
                'answer' => 'Yes — downloaded guides are available offline on your device. Make sure to download them while you have an internet connection. Offline content updates when you reconnect.',
                'category' => 'pricing',
                'order_index' => 3,
            ],
            [
                'question' => 'Can I use one subscription on multiple devices?',
                'answer' => 'Yes, you can sign in on multiple devices with your account. Some limits may apply depending on concurrent usage; contact support if you need team or enterprise access.',
                'category' => 'pricing',
                'order_index' => 4,
            ],
            [
                'question' => 'How do I update my payment method?',
                'answer' => 'Go to your account settings → Billing to update payment details. If you encounter issues updating your card, contact our billing team and we’ll help you update it securely.',
                'category' => 'pricing',
                'order_index' => 5,
            ],
        ];

        foreach ($faqs as $faqData) {
            $faqData['id'] = Str::uuid();
            Faq::create($faqData);
        }
    }
}
