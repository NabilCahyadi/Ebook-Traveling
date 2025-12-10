<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LandingPageSection;

class UpdateLandingPageSectionsWithDummyDataSeeder extends Seeder
{
    public function run()
    {
        // Update Hero section (id = order 10)
        $heroSection = LandingPageSection::where('section_type', 'hero')->first();
        if ($heroSection) {
            $heroSection->update([
                'section_data' => [
                    'title' => 'Discover Amazing Travel Ebooks',
                    'subtitle' => 'Explore the world through our curated collection of travel guides, stories, and cultural insights from destinations around the globe.',
                    'button_text' => 'Browse Ebooks',
                    'button_link' => '/ebooks',
                ]
            ]);
        }

        // Update About section (id = order 11)
        $aboutSection = LandingPageSection::where('section_type', 'about')->first();
        if ($aboutSection) {
            $aboutSection->update([
                'section_data' => [
                    'heading' => 'About MeatMap',
                    'description' => 'MeatMap is your ultimate destination for discovering travel ebooks and guides. We curate the best content from travelers and writers worldwide, bringing you authentic stories, practical tips, and cultural insights. Our mission is to inspire your next adventure and help you explore the world from the comfort of your home.',
                ]
            ]);
        }

        // Update Features section (id = order 12)
        $featuresSection = LandingPageSection::where('section_type', 'features')->first();
        if ($featuresSection) {
            $featuresSection->update([
                'section_title' => 'Why Choose MeatMap',
                'section_data' => [
                    'items' => [
                        [
                            'icon' => 'ti-book',
                            'title' => 'Curated Content',
                            'description' => 'Hand-picked ebooks from verified authors and travelers with real experiences.'
                        ],
                        [
                            'icon' => 'ti-world',
                            'title' => 'Global Coverage',
                            'description' => 'Discover destinations from every corner of the world with detailed guides.'
                        ],
                        [
                            'icon' => 'ti-download',
                            'title' => 'Offline Access',
                            'description' => 'Download and read your ebooks anywhere, even without internet connection.'
                        ],
                        [
                            'icon' => 'ti-star',
                            'title' => 'Quality Reviews',
                            'description' => 'Read honest reviews from our community to find the best travel guides.'
                        ],
                        [
                            'icon' => 'ti-clock',
                            'title' => 'Regular Updates',
                            'description' => 'New ebooks added weekly with fresh content and updated information.'
                        ],
                        [
                            'icon' => 'ti-shield-check',
                            'title' => 'Secure Platform',
                            'description' => 'Safe and encrypted transactions for worry-free purchases.'
                        ],
                    ]
                ]
            ]);
        }

        // Update Services section (id = order 13)
        $servicesSection = LandingPageSection::where('section_type', 'services')->first();
        if ($servicesSection) {
            $servicesSection->update([
                'section_title' => 'Our Services',
                'section_data' => [
                    'items' => [
                        [
                            'icon' => 'ti-book-2',
                            'title' => 'Ebook Library',
                            'description' => 'Access thousands of travel ebooks covering all destinations'
                        ],
                        [
                            'icon' => 'ti-users',
                            'title' => 'Community',
                            'description' => 'Join our community of travelers and share experiences'
                        ],
                        [
                            'icon' => 'ti-headphones',
                            'title' => 'Support',
                            'description' => '24/7 customer support to help you with any questions'
                        ],
                        [
                            'icon' => 'ti-crown',
                            'title' => 'Premium Plans',
                            'description' => 'Exclusive access to premium content and features'
                        ],
                    ]
                ]
            ]);
        }

        // Update Testimonial section (id = order 14)
        $testimonialSection = LandingPageSection::where('section_type', 'testimonial')->first();
        if ($testimonialSection) {
            $testimonialSection->update([
                'section_title' => 'What Our Readers Say',
                'section_data' => [
                    'items' => [
                        [
                            'name' => 'Sarah Johnson',
                            'position' => 'Travel Blogger',
                            'message' => 'MeatMap has completely transformed how I plan my trips. The ebooks are detailed, well-written, and packed with insider tips you won\'t find anywhere else!'
                        ],
                        [
                            'name' => 'Michael Chen',
                            'position' => 'Adventure Traveler',
                            'message' => 'I love the variety of destinations covered. Whether I\'m looking for city guides or off-the-beaten-path adventures, MeatMap always delivers quality content.'
                        ],
                        [
                            'name' => 'Emma Rodriguez',
                            'position' => 'Digital Nomad',
                            'message' => 'The offline access feature is a game-changer! I can read my ebooks on flights and in remote areas without worrying about internet connection.'
                        ],
                        [
                            'name' => 'David Thompson',
                            'position' => 'Photographer',
                            'message' => 'As a travel photographer, I need accurate information about locations. MeatMap\'s ebooks provide exactly that, plus amazing photography tips for each destination.'
                        ],
                        [
                            'name' => 'Lisa Anderson',
                            'position' => 'Food Enthusiast',
                            'message' => 'The cultural insights and food recommendations in these ebooks are incredible. I\'ve discovered so many authentic local restaurants thanks to MeatMap!'
                        ],
                        [
                            'name' => 'James Wilson',
                            'position' => 'Budget Traveler',
                            'message' => 'MeatMap offers great value for money. The subscription plan gives me access to unlimited ebooks, which has saved me hundreds on travel guide books.'
                        ],
                    ]
                ]
            ]);
        }

        // Update CTA section (id = order 15)
        $ctaSection = LandingPageSection::where('section_type', 'cta')->first();
        if ($ctaSection) {
            $ctaSection->update([
                'section_data' => [
                    'text' => 'Ready to Start Your Journey? Join thousands of travelers exploring the world with MeatMap!',
                    'button_text' => 'Get Started Free',
                    'button_link' => '/register',
                ]
            ]);
        }

        // Update FAQ section (id = order 16)
        $faqSection = LandingPageSection::where('section_type', 'faq')->first();
        if ($faqSection) {
            $faqSection->update([
                'section_title' => 'Frequently Asked Questions',
                'section_data' => [
                    'items' => [
                        [
                            'question' => 'How do I download ebooks?',
                            'answer' => 'Once you purchase or subscribe, you can download ebooks directly from your library page. Simply click the download button and the ebook will be saved to your device for offline reading.'
                        ],
                        [
                            'question' => 'Can I read ebooks on multiple devices?',
                            'answer' => 'Yes! Your account can be accessed from any device. Your library syncs across all devices, so you can start reading on your phone and continue on your tablet or computer.'
                        ],
                        [
                            'question' => 'What formats are available?',
                            'answer' => 'Our ebooks are available in PDF format, which is compatible with most devices and e-readers. You can read them using any PDF reader app.'
                        ],
                        [
                            'question' => 'Is there a subscription plan?',
                            'answer' => 'Yes, we offer flexible subscription plans that give you unlimited access to our entire library. Check out our pricing page for more details on available plans.'
                        ],
                        [
                            'question' => 'Can I get a refund?',
                            'answer' => 'We offer a 7-day money-back guarantee on all purchases. If you\'re not satisfied with an ebook, contact our support team within 7 days for a full refund.'
                        ],
                        [
                            'question' => 'How often is content updated?',
                            'answer' => 'We add new ebooks every week and regularly update existing content to ensure all information is current and accurate. Premium members get early access to new releases.'
                        ],
                    ]
                ]
            ]);
        }

        // Update Gallery section (id = order 17) - Note: This needs actual images to be uploaded
        $gallerySection = LandingPageSection::where('section_type', 'gallery')->first();
        if ($gallerySection) {
            $gallerySection->update([
                'section_title' => 'Travel Inspiration Gallery',
                'section_data' => [
                    'images' => [] // Empty for now, admin can upload via form
                ]
            ]);
        }

        // Update Contact section (id = order 18)
        $contactSection = LandingPageSection::where('section_type', 'contact')->first();
        if ($contactSection) {
            $contactSection->update([
                'section_title' => 'Get In Touch',
                'section_data' => [
                    'address' => 'Jl. Sudirman No. 123, Jakarta Pusat, DKI Jakarta 10220, Indonesia',
                    'email' => 'hello@meatmap.com',
                    'phone' => '+62 21 1234 5678',
                    'map_embed' => '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.521260322283!2d106.8195613!3d-6.1944491!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f5d2e764b12d%3A0x3d2ad6e1e0e9bcc8!2sMonas!5e0!3m2!1sen!2sid!4v1234567890" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>'
                ]
            ]);
        }

        $this->command->info('Landing page sections updated with dummy data successfully!');
    }
}
