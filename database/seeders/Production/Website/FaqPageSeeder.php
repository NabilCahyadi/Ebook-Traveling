<?php

namespace Database\Seeders\Production\Website;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Faq;
use Illuminate\Support\Str;

class FaqPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faqs = [
            // Subscription & Membership
            [
                'question' => 'What is included in the monthly MeatMap subscription?',
                'answer' => "The monthly MeatMap subscription gives you:\n- Unlimited access to the entire collection of travel eBooks\n- Latest destination guides every month\n- Download eBooks for offline reading\n- Regular content updates and exclusive travel tips\n- Priority customer support 24/7",
                'category' => 'Subscription & Membership',
                'order_index' => 1,
            ],
            [
                'question' => 'Can I cancel my subscription anytime?',
                'answer' => 'Yes, you can cancel your subscription at any time via the "Billing" page in your account. The cancellation will be effective at the end of the current billing period. There are no cancellation fees.',
                'category' => 'Subscription & Membership',
                'order_index' => 2,
            ],
            [
                'question' => 'Is there an annual subscription with a discount?',
                'answer' => 'Yes, we offer an annual subscription plan with a discount of up to 30% compared to the monthly subscription. The annual package provides full access for 12 months with a single payment.',
                'category' => 'Subscription & Membership',
                'order_index' => 3,
            ],

            // Payments & Transactions
            [
                'question' => 'What payment methods are accepted?',
                'answer' => "We accept various payment methods:\n- Bank Transfer: BCA, BNI, Mandiri, BRI, and other banks\n- E-Wallet: Gopay, OVO, Dana, LinkAja\n- Credit Cards: Visa, Mastercard, JCB\n- QRIS: Payment via QR Code",
                'category' => 'Payments & Transactions',
                'order_index' => 1,
            ],
            [
                'question' => 'What is the refund process?',
                'answer' => "Refund policy:\n- Refunds can be requested within 7 days of purchase\n- Only valid if the eBook has not been downloaded or accessed\n- The refund process takes 3-7 working days\n- Funds are returned to the original payment method\n\nFull details are on the Refund Policy page.",
                'category' => 'Payments & Transactions',
                'order_index' => 2,
            ],
            [
                'question' => 'What happens if the payment fails?',
                'answer' => "If the payment fails:\n- The transaction status will be marked \"Failed\"\n- You can try another payment method\n- Failed transactions will not be charged\n- Contact support if a double charge occurs",
                'category' => 'Payments & Transactions',
                'order_index' => 3,
            ],

            // eBook Access & Reading
            [
                'question' => 'How do I access the eBook after subscribing?',
                'answer' => "After a successful subscription:\n1. Log in to your MeatMap account\n2. Go to the \"Library\" or \"My Collection\" page\n3. Click on the eBook you want to read\n4. Choose \"Read in Browser\" or \"Download\"",
                'category' => 'eBook Access & Reading',
                'order_index' => 1,
            ],
            [
                'question' => 'Can the eBooks be read offline?',
                'answer' => "Yes! You can download eBooks for offline reading:\n- Download available in PDF, EPUB, and MOBI formats\n- Downloaded eBooks are available on your device\n- No internet connection needed to read\n- Re-download is available anytime during the subscription period",
                'category' => 'eBook Access & Reading',
                'order_index' => 2,
            ],
            [
                'question' => 'On which devices can I read the eBooks?',
                'answer' => "MeatMap eBooks can be accessed on:\n- Smartphone & Tablet: Android and iOS via browser\n- Laptop/PC: All modern browsers (Chrome, Firefox, Safari, Edge)\n- E-Reader: Kindle (MOBI format), Kobo, and other e-readers\n- Maximum of 3 active devices simultaneously",
                'category' => 'eBook Access & Reading',
                'order_index' => 3,
            ],

            // Account & Technical Support
            [
                'question' => 'How do I reset my password?',
                'answer' => "To reset your password:\n1. Click \"Forgot Password\" on the login page\n2. Enter your registered email\n3. Check your email for the password reset link\n4. Click the link and create a new password\n5. The reset link is valid for 1 hour",
                'category' => 'Account & Technical Support',
                'order_index' => 1,
            ],
            [
                'question' => 'Can I subscribe without a credit card?',
                'answer' => "Certainly! Besides credit cards, you can use:\n- Bank transfer (virtual account)\n- E-wallet (Gopay, OVO, Dana)\n- Payment via minimarkets (Alfamart, Indomaret)\n- QRIS for quick payment",
                'category' => 'Account & Technical Support',
                'order_index' => 2,
            ],
            [
                'question' => 'What if I encounter technical problems?',
                'answer' => "If you experience technical problems:\n- Check your internet connection\n- Clear browser cache and cookies\n- Try using a different browser\n- Contact our support team via WhatsApp or email\n- Include an error screenshot for faster assistance",
                'category' => 'Account & Technical Support',
                'order_index' => 3,
            ],

            // Content & Features
            [
                'question' => 'How often is new content added?',
                'answer' => "We routinely add new content:\n- New eBooks: 5-10 titles every month\n- Content Updates: Existing guides are regularly updated\n- New Destinations: Trending destinations are added every 2 weeks\n- Seasonal Guide: Seasonal guides for special holidays",
                'category' => 'Content & Features',
                'order_index' => 1,
            ],
            [
                'question' => 'Can I give ratings and reviews for the eBooks?',
                'answer' => "Yes! We highly appreciate your feedback:\n- Give a 1-5 star rating for each eBook\n- Write a review based on your reading experience\n- Reviews help other travelers choose the best guide\n- Ratings and reviews will be displayed publicly",
                'category' => 'Content & Features',
                'order_index' => 2,
            ],
            [
                'question' => 'Is there a search feature for specific destinations?',
                'answer' => "Yes, we have a complete search feature:\n- Search by destination (Bali, Japan, Europe, etc.)\n- Filter by category (Backpacker, Luxury, Family, etc.)\n- Search by keyword (culinary, budget, accommodation)\n- Sort by rating, newest, or most popular",
                'category' => 'Content & Features',
                'order_index' => 3,
            ],
        ];

        foreach ($faqs as $faq) {
            Faq::create([
                'id' => Str::uuid(),
                'question' => $faq['question'],
                'answer' => $faq['answer'],
                'category' => $faq['category'],
                'order_index' => $faq['order_index'],
                'is_active' => true,
            ]);
        }
    }
}
