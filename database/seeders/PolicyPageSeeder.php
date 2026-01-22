<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Page;
use Illuminate\Support\Str;
use App\Models\PageSection;

class PolicyPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [

            // ========================================================================
            // HELP CENTER
            // ========================================================================
            [
                'page_type' => 'help',
                'section_title' => '1. How to Register a MeatMap Account',
                'subsection_title' => '1.1. Via Website',
                'content' => "Visit the MeatMap website at meatmap.co\nClick the \"Daftar\" or \"Register\" button in the upper right corner\nFill in complete personal details (name, email, password, phone number)\nCheck the box to agree to the Terms & Conditions and Privacy Policy\nClick \"Register\" to create an account\nCheck your email for account verification\nClick the verification link in the email to activate your account",
                'order_index' => 1,
            ],
            [
                'page_type' => 'help',
                'section_title' => '1. How to Register a MeatMap Account',
                'subsection_title' => '1.2. Login with Google',
                'content' => "Click the \"Login with Google\" button on the registration page\nSelect the Google account you want to use\nGrant the requested access permissions\nYour account will be automatically created and verified\nComplete your profile for a more personalized experience",
                'order_index' => 2,
            ],
            [
                'page_type' => 'help',
                'section_title' => '2. How to Subscribe',
                'subsection_title' => '2.1. Monthly/Annual Subscription',
                'content' => "Log in to your MeatMap account\nSelect the ebook you want to read or click \"Subscribe\"\nChoose a subscription plan (Monthly/Annual)\nSelect the desired payment method\nFollow the payment instructions until completion\nWait for payment confirmation (1-5 minutes)\nFull access to all ebooks will be automatically active",
                'order_index' => 3,
            ],
            [
                'page_type' => 'help',
                'section_title' => '2. How to Subscribe',
                'subsection_title' => '2.2. Payment Methods',
                'content' => "Bank Transfer: BCA, BNI, Mandiri, BRI, and other banks\nE-Wallet: Gopay, OVO, Dana, LinkAja\nCredit Card: Visa, Mastercard, JCB\nQRIS: Scan the QR code for quick payment\nMinimarket: Alfamart, Indomaret (pay within 24 hours)",
                'order_index' => 4,
            ],
            [
                'page_type' => 'help',
                'section_title' => '3. How to Access Ebooks',
                'subsection_title' => '3.1. Reading in Browser',
                'content' => "Log in to your subscribed account\nGo to the \"Library\" or \"My Collection\" page\nClick the cover of the ebook you want to read\nClick the \"Read in Browser\" button\nThe ebook will open in our dedicated reader\nUse the zoom, bookmark, and text search features",
                'order_index' => 5,
            ],
            [
                'page_type' => 'help',
                'section_title' => '3. How to Access Ebooks',
                'subsection_title' => '3.2. Download for Offline',
                'content' => "On the ebook detail page, click the \"Download\" button\nSelect the desired format (PDF, EPUB, MOBI)\nWait for the download process to complete\nThe file will be saved in your device's download folder\nOpen with your favorite reader application\nThe file can be read anytime without an internet connection",
                'order_index' => 6,
            ],
            [
                'page_type' => 'help',
                'section_title' => '4. Troubleshooting',
                'subsection_title' => '4.1. Payment Issues',
                'content' => "Pending payment: Wait 5-15 minutes, refresh the page\nVirtual Account expired: Create a new transaction\nE-wallet failed: Ensure sufficient balance\nCredit card rejected: Contact the issuing bank\nDouble charge: Contact customer service immediately",
                'order_index' => 7,
            ],
            [
                'page_type' => 'help',
                'section_title' => '4. Troubleshooting',
                'subsection_title' => '4.2. Ebook Access Issues',
                'content' => "Cannot log in: Reset password or use the forgot password feature\nEbook won't open: Clear browser cache or use a different browser\nDownload failed: Check internet connection and storage space\nFormat not supported: Download an alternative format (PDF/EPUB/MOBI)\nAccess denied: Ensure the subscription is still active",
                'order_index' => 8,
            ],
            [
                'page_type' => 'help',
                'section_title' => '5. Account Settings',
                'subsection_title' => '5.1. Edit Profile',
                'content' => "Click the profile photo in the upper right corner\nSelect \"Edit Profile\" or \"Account Settings\"\nChange the necessary data (name, photo, phone number)\nClick \"Save Changes\"",
                'order_index' => 9,
            ],
            [
                'page_type' => 'help',
                'section_title' => '5. Account Settings',
                'subsection_title' => '5.2. Change Password',
                'content' => "Go to \"Account Settings\" → \"Security\"\nClick \"Change Password\"\nEnter the old password and the new password\nConfirm the new password\nClick \"Update Password\"",
                'order_index' => 10,
            ],
            [
                'page_type' => 'help',
                'section_title' => '5. Account Settings',
                'subsection_title' => '5.3. Manage Subscription',
                'content' => "Go to \"Billing\" or \"My Subscription\"\nView the current subscription status\nRenew the subscription before it expires\nCancel the subscription (if necessary)\nDownload the invoice for accounting purposes",
                'order_index' => 11,
            ],

            // ========================================================================
            // PRIVACY POLICY
            // ========================================================================
            [
                'page_type' => 'privacy',
                'section_title' => '1. Information We Collect',
                'subsection_title' => '1.1. Personal Data You Provide',
                'content' => "Account Data: Full name, email address, phone number, and encrypted password when you create an account.\nProfile Data: Date of birth, gender, and profile photo.\nTransaction Data: Information related to subscription or ebook/guide purchases (payment method, purchase history, although We do not store credit card data directly).\nCommunication: Information you provide when contacting customer service or participating in surveys.",
                'order_index' => 12,
            ],
            [
                'page_type' => 'privacy',
                'section_title' => '1. Information We Collect',
                'subsection_title' => '1.2. Automatically Collected Data',
                'content' => "Location Data: The geographical location of your device (if you enable location services) to provide relevant destination content (\"Near Me\").\nDevice Data: IP address, device type, operating system, unique device identifier, and cellular network data.\nUsage Data: Pages you visit, time spent on those pages, links clicked, and other interaction patterns.",
                'order_index' => 13,
            ],
            [
                'page_type' => 'privacy',
                'section_title' => '2. Use of Information',
                'subsection_title' => null,
                'content' => "Providing, administering, and maintaining Our Service (including granting access to ebooks and guides).\nProcessing your transactions and sending purchase confirmations.\nAnalyzing Service usage to improve functionality and user experience.\nSending technical updates, security notifications, and support messages.\nConducting marketing and promotions, including sending information about Our new offers and products (if you consent).\nProtecting, investigating, and preventing illegal activities, fraud, or misuse.",
                'order_index' => 14,
            ],
            [
                'page_type' => 'privacy',
                'section_title' => '3. Disclosure and Sharing of Information',
                'subsection_title' => null,
                'content' => "Service Providers: To third parties who perform services on Our behalf (e.g., payment processors, cloud service providers, or analytics services). These parties only have access to the information necessary to perform their functions.\nLegal Compliance: If required by law, court order, or valid legal process.\nBusiness Transfer: In connection with a merger, sale of company assets, financing, or acquisition of all or part of Our business.\nWith Your Consent: We may share your information for other purposes that We explain at the time of data collection, with your consent.",
                'order_index' => 15,
            ],
            [
                'page_type' => 'privacy',
                'section_title' => '4. Data Security',
                'subsection_title' => null,
                'content' => "We use encryption (SSL/TLS) to protect the transmission of sensitive data.\nPassword data is stored in an irreversible hash format.\nAccess to personal data is restricted only to employees and contractors who need the information to perform their duties.",
                'order_index' => 16,
            ],
            [
                'page_type' => 'privacy',
                'section_title' => '5. User Choices and Rights',
                'subsection_title' => null,
                'content' => "Access and Correction: You can review and update your account information through profile settings.\nWithdrawal of Consent: You can withdraw your consent for the collection of certain data (such as location data) at any time through your device settings.\nUnsubscribe: You can opt out of receiving marketing emails from Us by clicking the \"unsubscribe\" link in those emails.\nData Deletion: You can request the deletion of your account and personal data by contacting customer service.",
                'order_index' => 17,
            ],
            [
                'page_type' => 'privacy',
                'section_title' => '6. Changes to This Privacy Policy',
                'subsection_title' => null,
                'content' => "We may update this Privacy Policy from time to time. We will notify you of any changes by posting the new Privacy Policy on this page. You are advised to review this Privacy Policy periodically for any changes. Changes are effective immediately upon being posted on this page.",
                'order_index' => 18,
            ],
            [
                'page_type' => 'privacy',
                'section_title' => '7. Contact Us',
                'subsection_title' => null,
                'content' => "Email : privacy@meatmap.com\nAddress : [Your Company Address]\nPhone Number : [Your Phone Number]",
                'order_index' => 19,
            ],

            // ========================================================================
            // TERMS & CONDITIONS
            // ========================================================================
            [
                'page_type' => 'terms',
                'section_title' => '1. Terms and Conditions for Ebook Service Usage',
                'subsection_title' => '1.1. User Account',
                'content' => "You must be at least 18 years old, or have legal permission from a parent/guardian to use this Service.\nYou are prohibited from sharing your account login details with any other party.",
                'order_index' => 20,
            ],
            [
                'page_type' => 'terms',
                'section_title' => '1. Terms and Conditions for Ebook Service Usage',
                'subsection_title' => '1.2. Ebook License and Copyright',
                'content' => "You are granted a limited, non-exclusive, and non-transferable license to access and read the content for personal, non-commercial use.\nYou are prohibited from copying, distributing, selling, or modifying ebook content without written permission.",
                'order_index' => 21,
            ],
            [
                'page_type' => 'terms',
                'section_title' => '2. Refund Policy',
                'subsection_title' => '2.1. General Refund Conditions',
                'content' => "The purchase was made less than 7 days ago.\nThe purchased ebook content is proven to be damaged, incomplete, or inaccessible due to technical issues on our side.\nThe user has not downloaded or accessed more than 5% of the total ebook content.",
                'order_index' => 22,
            ],
            [
                'page_type' => 'terms',
                'section_title' => '2. Refund Policy',
                'subsection_title' => '2.2. Refund Process',
                'content' => "Requests will be reviewed within 5 business days.\nIf approved, the funds will be returned to the original payment method within 7-14 business days, depending on your bank's policy.\nWe reserve the right to reject refund requests if policy abuse is found.",
                'order_index' => 23,
            ],

            // ========================================================================
            // SHOPPING POLICY
            // ========================================================================
            [
                'page_type' => 'shopping',
                'section_title' => '1. Purchase Process',
                'subsection_title' => '1.1. How to Shop',
                'content' => "Select the ebook or guide you wish to purchase\nClick the \"Buy Now\" or \"Add to Cart\" button\nLogin or register for a MeatMap account (if you don't have one)\nSelect the available payment method\nConfirm and complete the payment",
                'order_index' => 24,
            ],
            [
                'page_type' => 'shopping',
                'section_title' => '1. Purchase Process',
                'subsection_title' => '1.2. Purchase Confirmation',
                'content' => "Purchase confirmation email\nDirect access to the purchased digital product\nNotification in your MeatMap account",
                'order_index' => 25,
            ],
            [
                'page_type' => 'shopping',
                'section_title' => '2. Digital Products',
                'subsection_title' => '2.1. Access and Usage',
                'content' => "Your MeatMap account in the \"Library\" or \"My Collection\" section\nMeatMap application (if available)\nDownload link sent via email",
                'order_index' => 26,
            ],
            [
                'page_type' => 'shopping',
                'section_title' => '2. Digital Products',
                'subsection_title' => '2.2. Format and Compatibility',
                'content' => "PDF: Readable on most devices\nEPUB: Standard format for e-readers\nMOBI: Specifically for Amazon Kindle",
                'order_index' => 27,
            ],
            [
                'page_type' => 'shopping',
                'section_title' => '3. Digital Product Delivery',
                'subsection_title' => null,
                'content' => "Instant: Direct access after successful payment\n24/7: Accessible anytime\nPermanent: As long as your account is active",
                'order_index' => 28,
            ],
            [
                'page_type' => 'shopping',
                'section_title' => '4. Restrictions and Usage Rights',
                'subsection_title' => null,
                'content' => "For personal use only\nProhibited from reproducing, distributing, or reselling\nMaximum of 3 devices per account\nAccess rights may be revoked if terms are violated",
                'order_index' => 29,
            ],

            // ========================================================================
            // PAYMENT POLICY
            // ========================================================================
            [
                'page_type' => 'payment',
                'section_title' => '1. Payment Methods',
                'subsection_title' => '1.1. Accepted Methods',
                'content' => "Available payment methods can be selected during the subscription transaction process.\n",
                'order_index' => 30,
            ],
            [
                'page_type' => 'payment',
                'section_title' => '2. Payment Process',
                'subsection_title' => '2.1. Payment Verification',
                'content' => "Instant: For e-wallets and credit cards (1-2 minutes)\n10-15 minutes: For virtual account bank transfers\n1-3 hours: For manual transfers",
                'order_index' => 31,
            ],
            [
                'page_type' => 'payment',
                'section_title' => '2. Payment Process',
                'subsection_title' => '2.2. Payment Deadline',
                'content' => "Virtual Account: 24 hours\nE-wallet: 1 hour\nQRIS: 30 minutes",
                'order_index' => 32,
            ],
            [
                'page_type' => 'payment',
                'section_title' => '3. Payment Security',
                'subsection_title' => null,
                'content' => "256-bit SSL Encryption\nPCI DSS compliant\nTwo-factor authentication\n24/7 transaction monitoring",
                'order_index' => 33,
            ],
            [
                'page_type' => 'payment',
                'section_title' => '4. Payment Issues and Solutions',
                'subsection_title' => '4.1. Failed Payment',
                'content' => "Insufficient balance\nTransaction limit exceeded\nNetwork or system issue\nCredit card rejected",
                'order_index' => 34,
            ],
            [
                'page_type' => 'payment',
                'section_title' => '4. Payment Issues and Solutions',
                'subsection_title' => '4.2. Double Charge',
                'content' => "Contact customer service immediately\nInclude proof of transaction\nRefund process 3-7 business days",
                'order_index' => 35,
            ],
        ];

        foreach ($data as $item) {
            PageSection::create([
                'id' => Str::uuid(),
                'page_type' => $item['page_type'],
                'section_title' => $item['section_title'],
                'subsection_title' => $item['subsection_title'],
                'content' => $item['content'],
                'order_index' => $item['order_index'],
            ]);
        }
    }
}
