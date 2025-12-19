<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Truncate existing permissions
        DB::table('role_permission')->delete();
        DB::table('permissions')->delete();

        $permissions = [
            // Navigation & Pages
            [
                'name' => 'access_home',
                'display_name' => 'Access Home Page',
                'description' => 'View and access homepage',
                'group' => 'Navigation & Pages',
                'module' => 'navigation',
            ],
            [
                'name' => 'access_destinations',
                'display_name' => 'Access Destinations Page',
                'description' => 'View destinations and cities',
                'group' => 'Navigation & Pages',
                'module' => 'navigation',
            ],
            [
                'name' => 'access_blog',
                'display_name' => 'Access Blog Page',
                'description' => 'Read blog articles',
                'group' => 'Navigation & Pages',
                'module' => 'navigation',
            ],
            [
                'name' => 'access_pricing',
                'display_name' => 'Access Pricing Page',
                'description' => 'View pricing and subscription plans',
                'group' => 'Navigation & Pages',
                'module' => 'navigation',
            ],
            [
                'name' => 'access_promo',
                'display_name' => 'Access Promo Page',
                'description' => 'View promotional offers',
                'group' => 'Navigation & Pages',
                'module' => 'navigation',
            ],


            // Ebook Features
            [
                'name' => 'view_ebook_library',
                'display_name' => 'View Ebook Library',
                'description' => 'Browse ebook library',
                'group' => 'Ebook Features',
                'module' => 'ebooks',
            ],
            [
                'name' => 'read_ebook',
                'display_name' => 'Read Ebooks',
                'description' => 'Read ebook content online',
                'group' => 'Ebook Features',
                'module' => 'ebooks',
            ],
            [
                'name' => 'download_ebook',
                'display_name' => 'Download Ebooks',
                'description' => 'Download ebooks for offline reading',
                'group' => 'Ebook Features',
                'module' => 'ebooks',
            ],
            [
                'name' => 'rate_ebook',
                'display_name' => 'Rate & Review Ebooks',
                'description' => 'Rate and review ebooks',
                'group' => 'Ebook Features',
                'module' => 'ebooks',
            ],
            [
                'name' => 'bookmark_ebook',
                'display_name' => 'Bookmark Ebooks',
                'description' => 'Save ebooks to bookmarks',
                'group' => 'Ebook Features',
                'module' => 'ebooks',
            ],

            // Creator Features
            [
                'name' => 'upload_ebook',
                'display_name' => 'Upload New Ebook',
                'description' => 'Upload new ebook as creator',
                'group' => 'Creator Features',
                'module' => 'creator',
            ],
            [
                'name' => 'edit_own_ebook',
                'display_name' => 'Edit Own Ebooks',
                'description' => 'Edit own uploaded ebooks',
                'group' => 'Creator Features',
                'module' => 'creator',
            ],
            [
                'name' => 'delete_own_ebook',
                'display_name' => 'Delete Own Ebooks',
                'description' => 'Delete own uploaded ebooks',
                'group' => 'Creator Features',
                'module' => 'creator',
            ],
            [
                'name' => 'view_ebook_analytics',
                'display_name' => 'View Ebook Analytics',
                'description' => 'View stats and analytics for own ebooks',
                'group' => 'Creator Features',
                'module' => 'creator',
            ],

            // Shopping & Payment
            [
                'name' => 'add_to_cart',
                'display_name' => 'Add Items to Cart',
                'description' => 'Add ebooks to shopping cart',
                'group' => 'Shopping & Payment',
                'module' => 'shopping',
            ],
            [
                'name' => 'checkout',
                'display_name' => 'Checkout & Payment',
                'description' => 'Process checkout and payment',
                'group' => 'Shopping & Payment',
                'module' => 'shopping',
            ],
            [
                'name' => 'use_promo_code',
                'display_name' => 'Use Promo Codes',
                'description' => 'Apply promo codes at checkout',
                'group' => 'Shopping & Payment',
                'module' => 'shopping',
            ],
            [
                'name' => 'view_order_history',
                'display_name' => 'View Order History',
                'description' => 'View past orders and transactions',
                'group' => 'Shopping & Payment',
                'module' => 'shopping',
            ],

            // Subscription Features
            [
                'name' => 'subscribe',
                'display_name' => 'Subscribe to Plans',
                'description' => 'Subscribe to membership plans',
                'group' => 'Subscription Features',
                'module' => 'subscription',
            ],
            [
                'name' => 'manage_subscription',
                'display_name' => 'Manage Own Subscription',
                'description' => 'Manage own subscription details',
                'group' => 'Subscription Features',
                'module' => 'subscription',
            ],
            [
                'name' => 'cancel_subscription',
                'display_name' => 'Cancel Subscription',
                'description' => 'Cancel own subscription',
                'group' => 'Subscription Features',
                'module' => 'subscription',
            ],
            [
                'name' => 'upgrade_subscription',
                'display_name' => 'Upgrade Subscription Plan',
                'description' => 'Upgrade to higher subscription tier',
                'group' => 'Subscription Features',
                'module' => 'subscription',
            ],

            // Profile & Settings
            [
                'name' => 'edit_profile',
                'display_name' => 'Edit Profile',
                'description' => 'Edit own profile information',
                'group' => 'Profile & Settings',
                'module' => 'profile',
            ],
            [
                'name' => 'change_password',
                'display_name' => 'Change Password',
                'description' => 'Change own password',
                'group' => 'Profile & Settings',
                'module' => 'profile',
            ],
            [
                'name' => 'delete_account',
                'display_name' => 'Delete Own Account',
                'description' => 'Delete own user account',
                'group' => 'Profile & Settings',
                'module' => 'profile',
            ],
            [
                'name' => 'view_notifications',
                'display_name' => 'View Notifications',
                'description' => 'View notifications and alerts',
                'group' => 'Profile & Settings',
                'module' => 'profile',
            ],

            // Social Features
            [
                'name' => 'comment_blog',
                'display_name' => 'Comment on Blogs',
                'description' => 'Post comments on blog articles',
                'group' => 'Social Features',
                'module' => 'social',
            ],
            [
                'name' => 'share_content',
                'display_name' => 'Share Content',
                'description' => 'Share ebooks and content',
                'group' => 'Social Features',
                'module' => 'social',
            ],
            [
                'name' => 'follow_creators',
                'display_name' => 'Follow Creators',
                'description' => 'Follow favorite creators',
                'group' => 'Social Features',
                'module' => 'social',
            ],

            // Collections
            [
                'name' => 'view_collections',
                'display_name' => 'View Collections',
                'description' => 'View ebook collections',
                'group' => 'Collections',
                'module' => 'collections',
            ],
            [
                'name' => 'create_collection',
                'display_name' => 'Create Own Collections',
                'description' => 'Create personal ebook collections',
                'group' => 'Collections',
                'module' => 'collections',
            ],
            [
                'name' => 'add_to_collection',
                'display_name' => 'Add Ebooks to Collections',
                'description' => 'Add ebooks to collections',
                'group' => 'Collections',
                'module' => 'collections',
            ],

            // Company Pages
            [
                'name' => 'access_about_us',
                'display_name' => 'Access About Us Page',
                'description' => 'View about us page',
                'group' => 'Company',
                'module' => 'company',
            ],
            [
                'name' => 'access_terms_conditions',
                'display_name' => 'Access Terms & Conditions Page',
                'description' => 'View terms and conditions page',
                'group' => 'Company',
                'module' => 'company',
            ],
            [
                'name' => 'access_contact_us',
                'display_name' => 'Access Contact Us Page',
                'description' => 'View contact us page',
                'group' => 'Company',
                'module' => 'company',
            ],
            [
                'name' => 'access_help_center',
                'display_name' => 'Access Help Center Page',
                'description' => 'View help center / support page',
                'group' => 'Company',
                'module' => 'company',
            ],
            [
                'name' => 'access_privacy_policy',
                'display_name' => 'Access Privacy Policy Page',
                'description' => 'View privacy policy page',
                'group' => 'Company',
                'module' => 'company',
            ],
            [
                'name' => 'access_shopping_policy',
                'display_name' => 'Access Shopping Policy Page',
                'description' => 'View shopping policy page',
                'group' => 'Company',
                'module' => 'company',
            ],
            [
                'name' => 'access_payment_policy',
                'display_name' => 'Access Payment Policy Page',
                'description' => 'View payment policy page',
                'group' => 'Company',
                'module' => 'company',
            ],
            [
                'name' => 'access_faq',
                'display_name' => 'Access FAQ Page',
                'description' => 'View frequently asked questions page',
                'group' => 'Company',
                'module' => 'company',
            ],

            // Account Dashboard Menu (Controls sidebar menu visibility)
            [
                'name' => 'access_wishlist',
                'display_name' => 'Show Wishlist Menu',
                'description' => 'Show Wishlist menu in account sidebar',
                'group' => 'Account Dashboard',
                'module' => 'account',
            ],
            [
                'name' => 'access_creator_dashboard',
                'display_name' => 'Show Creator Dashboard Menu',
                'description' => 'Show Creator menu in account sidebar',
                'group' => 'Account Dashboard',
                'module' => 'account',
            ],
            [
                'name' => 'access_profile_settings',
                'display_name' => 'Show Profile Settings Menu',
                'description' => 'Show Profile Settings menu in account sidebar',
                'group' => 'Account Dashboard',
                'module' => 'account',
            ],
            [
                'name' => 'access_payment_history',
                'display_name' => 'Show Payment History Menu',
                'description' => 'Show Payment History menu in account sidebar',
                'group' => 'Account Dashboard',
                'module' => 'account',
            ],
        ];

        foreach ($permissions as $permission) {
            DB::table('permissions')->insert([
                'id' => Str::uuid(),
                'name' => $permission['name'],
                'display_name' => $permission['display_name'],
                'description' => $permission['description'],
                'group' => $permission['group'],
                'module' => $permission['module'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
