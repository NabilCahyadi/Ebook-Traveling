<?php

namespace Database\Seeders;

use App\Models\AdminPermission;
use Illuminate\Database\Seeder;

class AdminPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            // ============================================
            // USER MANAGEMENT (sort_order: 10)
            // ============================================
            // Users
            [
                'name' => 'users.view',
                'display_name' => 'View',
                'description' => 'View list of users',
                'module' => 'User Management',
                'sub_module' => 'Users',
                'group' => 'user_management',
                'sort_order' => 10,
            ],
            [
                'name' => 'users.create',
                'display_name' => 'Create',
                'description' => 'Add new user',
                'module' => 'User Management',
                'sub_module' => 'Users',
                'group' => 'user_management',
                'sort_order' => 10,
            ],
            [
                'name' => 'users.edit',
                'display_name' => 'Edit',
                'description' => 'Edit user data',
                'module' => 'User Management',
                'sub_module' => 'Users',
                'group' => 'user_management',
                'sort_order' => 10,
            ],
            [
                'name' => 'users.delete',
                'display_name' => 'Delete',
                'description' => 'Delete user',
                'module' => 'User Management',
                'sub_module' => 'Users',
                'group' => 'user_management',
                'sort_order' => 10,
            ],
            
            // Roles
            [
                'name' => 'roles.view',
                'display_name' => 'View',
                'description' => 'View user roles',
                'module' => 'User Management',
                'sub_module' => 'Roles',
                'group' => 'user_management',
                'sort_order' => 10,
            ],
            [
                'name' => 'roles.create',
                'display_name' => 'Create',
                'description' => 'Add new role',
                'module' => 'User Management',
                'sub_module' => 'Roles',
                'group' => 'user_management',
                'sort_order' => 10,
            ],
            [
                'name' => 'roles.edit',
                'display_name' => 'Edit',
                'description' => 'Edit role data',
                'module' => 'User Management',
                'sub_module' => 'Roles',
                'group' => 'user_management',
                'sort_order' => 10,
            ],
            [
                'name' => 'roles.delete',
                'display_name' => 'Delete',
                'description' => 'Delete role',
                'module' => 'User Management',
                'sub_module' => 'Roles',
                'group' => 'user_management',
                'sort_order' => 10,
            ],

            // ============================================
            // EBOOK MANAGEMENT (sort_order: 20)
            // ============================================
            // Ebooks
            [
                'name' => 'ebooks.view',
                'display_name' => 'View',
                'description' => 'View list of ebooks',
                'module' => 'Ebook Management',
                'sub_module' => 'Ebooks',
                'group' => 'ebook_management',
                'sort_order' => 20,
            ],
            [
                'name' => 'ebooks.create',
                'display_name' => 'Create',
                'description' => 'Add new ebook',
                'module' => 'Ebook Management',
                'sub_module' => 'Ebooks',
                'group' => 'ebook_management',
                'sort_order' => 20,
            ],
            [
                'name' => 'ebooks.edit',
                'display_name' => 'Edit',
                'description' => 'Edit ebook data',
                'module' => 'Ebook Management',
                'sub_module' => 'Ebooks',
                'group' => 'ebook_management',
                'sort_order' => 20,
            ],
            [
                'name' => 'ebooks.delete',
                'display_name' => 'Delete',
                'description' => 'Delete ebook',
                'module' => 'Ebook Management',
                'sub_module' => 'Ebooks',
                'group' => 'ebook_management',
                'sort_order' => 20,
            ],
            [
                'name' => 'ebooks.approve',
                'display_name' => 'Approve',
                'description' => 'Approve or reject ebook',
                'module' => 'Ebook Management',
                'sub_module' => 'Ebooks',
                'group' => 'ebook_management',
                'sort_order' => 20,
            ],
            
            // Categories
            [
                'name' => 'categories.view',
                'display_name' => 'View',
                'description' => 'View ebook categories',
                'module' => 'Ebook Management',
                'sub_module' => 'Categories',
                'group' => 'ebook_management',
                'sort_order' => 20,
            ],
            [
                'name' => 'categories.manage',
                'display_name' => 'Manage',
                'description' => 'Add, edit, delete categories',
                'module' => 'Ebook Management',
                'sub_module' => 'Categories',
                'group' => 'ebook_management',
                'sort_order' => 20,
            ],
            [
                'name' => 'categories.create',
                'display_name' => 'Create',
                'description' => 'Add new category',
                'module' => 'Ebook Management',
                'sub_module' => 'Categories',
                'group' => 'ebook_management',
                'sort_order' => 20,
            ],
            [
                'name' => 'categories.edit',
                'display_name' => 'Edit',
                'description' => 'Edit category data',
                'module' => 'Ebook Management',
                'sub_module' => 'Categories',
                'group' => 'ebook_management',
                'sort_order' => 20,
            ],
            [
                'name' => 'categories.delete',
                'display_name' => 'Delete',
                'description' => 'Delete category',
                'module' => 'Ebook Management',
                'sub_module' => 'Categories',
                'group' => 'ebook_management',
                'sort_order' => 20,
            ],
            
            // Cities
            [
                'name' => 'cities.view',
                'display_name' => 'View',
                'description' => 'View city list',
                'module' => 'Ebook Management',
                'sub_module' => 'Cities',
                'group' => 'ebook_management',
                'sort_order' => 20,
            ],
            [
                'name' => 'cities.create',
                'display_name' => 'Create',
                'description' => 'Add new city',
                'module' => 'Ebook Management',
                'sub_module' => 'Cities',
                'group' => 'ebook_management',
                'sort_order' => 20,
            ],
            [
                'name' => 'cities.edit',
                'display_name' => 'Edit',
                'description' => 'Edit city data',
                'module' => 'Ebook Management',
                'sub_module' => 'Cities',
                'group' => 'ebook_management',
                'sort_order' => 20,
            ],
            [
                'name' => 'cities.delete',
                'display_name' => 'Delete',
                'description' => 'Delete city',
                'module' => 'Ebook Management',
                'sub_module' => 'Cities',
                'group' => 'ebook_management',
                'sort_order' => 20,
            ],

            // ============================================
            // BLOG MANAGEMENT (sort_order: 30)
            // ============================================
            // Blogs
            [
                'name' => 'blogs.view',
                'display_name' => 'View',
                'description' => 'View list of blog articles',
                'module' => 'Blog Management',
                'sub_module' => 'Blogs',
                'group' => 'content_management',
                'sort_order' => 30,
            ],
            [
                'name' => 'blogs.create',
                'display_name' => 'Create',
                'description' => 'Add new blog article',
                'module' => 'Blog Management',
                'sub_module' => 'Blogs',
                'group' => 'content_management',
                'sort_order' => 30,
            ],
            [
                'name' => 'blogs.edit',
                'display_name' => 'Edit',
                'description' => 'Edit blog article',
                'module' => 'Blog Management',
                'sub_module' => 'Blogs',
                'group' => 'content_management',
                'sort_order' => 30,
            ],
            [
                'name' => 'blogs.delete',
                'display_name' => 'Delete',
                'description' => 'Delete blog article',
                'module' => 'Blog Management',
                'sub_module' => 'Blogs',
                'group' => 'content_management',
                'sort_order' => 30,
            ],
            
            // Blog Categories
            [
                'name' => 'blog-categories.view',
                'display_name' => 'View',
                'description' => 'View blog categories',
                'module' => 'Blog Management',
                'sub_module' => 'Blog Categories',
                'group' => 'content_management',
                'sort_order' => 30,
            ],
            [
                'name' => 'blog-categories.create',
                'display_name' => 'Create',
                'description' => 'Add new blog category',
                'module' => 'Blog Management',
                'sub_module' => 'Blog Categories',
                'group' => 'content_management',
                'sort_order' => 30,
            ],
            [
                'name' => 'blog-categories.edit',
                'display_name' => 'Edit',
                'description' => 'Edit blog category',
                'module' => 'Blog Management',
                'sub_module' => 'Blog Categories',
                'group' => 'content_management',
                'sort_order' => 30,
            ],
            [
                'name' => 'blog-categories.delete',
                'display_name' => 'Delete',
                'description' => 'Delete blog category',
                'module' => 'Blog Management',
                'sub_module' => 'Blog Categories',
                'group' => 'content_management',
                'sort_order' => 30,
            ],
            
            // ============================================
            // SUBSCRIPTION MANAGEMENT (sort_order: 40)
            // ============================================
            // Subscription Plans
            [
                'name' => 'subscription-plans.view',
                'display_name' => 'View',
                'description' => 'View subscription plans',
                'module' => 'Subscription Management',
                'sub_module' => 'Subscription Plans',
                'group' => 'subscription_management',
                'sort_order' => 40,
            ],
            [
                'name' => 'subscription-plans.create',
                'display_name' => 'Create',
                'description' => 'Add new subscription plan',
                'module' => 'Subscription Management',
                'sub_module' => 'Subscription Plans',
                'group' => 'subscription_management',
                'sort_order' => 40,
            ],
            [
                'name' => 'subscription-plans.edit',
                'display_name' => 'Edit',
                'description' => 'Edit subscription plan',
                'module' => 'Subscription Management',
                'sub_module' => 'Subscription Plans',
                'group' => 'subscription_management',
                'sort_order' => 40,
            ],
            [
                'name' => 'subscription-plans.delete',
                'display_name' => 'Delete',
                'description' => 'Delete subscription plan',
                'module' => 'Subscription Management',
                'sub_module' => 'Subscription Plans',
                'group' => 'subscription_management',
                'sort_order' => 40,
            ],
            
            // Subscriptions (Manual & History)
            [
                'name' => 'subscriptions.view',
                'display_name' => 'View',
                'description' => 'View subscriptions & history',
                'module' => 'Subscription Management',
                'sub_module' => 'Subscriptions',
                'group' => 'subscription_management',
                'sort_order' => 40,
            ],
            [
                'name' => 'subscriptions.create',
                'display_name' => 'Create',
                'description' => 'Add new subscription',
                'module' => 'Subscription Management',
                'sub_module' => 'Subscriptions',
                'group' => 'subscription_management',
                'sort_order' => 40,
            ],
            [
                'name' => 'subscriptions.edit',
                'display_name' => 'Edit',
                'description' => 'Edit subscription (extend)',
                'module' => 'Subscription Management',
                'sub_module' => 'Subscriptions',
                'group' => 'subscription_management',
                'sort_order' => 40,
            ],
            [
                'name' => 'subscriptions.delete',
                'display_name' => 'Delete',
                'description' => 'Cancel subscription',
                'module' => 'Subscription Management',
                'sub_module' => 'Subscriptions',
                'group' => 'subscription_management',
                'sort_order' => 40,
            ],
            
            // Promos
            [
                'name' => 'promos.view',
                'display_name' => 'View',
                'description' => 'View promo codes',
                'module' => 'Subscription Management',
                'sub_module' => 'Promos',
                'group' => 'subscription_management',
                'sort_order' => 40,
            ],
            [
                'name' => 'promos.create',
                'display_name' => 'Create',
                'description' => 'Add new promo code',
                'module' => 'Subscription Management',
                'sub_module' => 'Promos',
                'group' => 'subscription_management',
                'sort_order' => 40,
            ],
            [
                'name' => 'promos.edit',
                'display_name' => 'Edit',
                'description' => 'Edit promo code',
                'module' => 'Subscription Management',
                'sub_module' => 'Promos',
                'group' => 'subscription_management',
                'sort_order' => 40,
            ],
            [
                'name' => 'promos.delete',
                'display_name' => 'Delete',
                'description' => 'Delete promo code',
                'module' => 'Subscription Management',
                'sub_module' => 'Promos',
                'group' => 'subscription_management',
                'sort_order' => 40,
            ],
            
            // ============================================
            // WEBSITE MANAGEMENT (sort_order: 50)
            // ============================================
            // Landing Page
            [
                'name' => 'website.landing-page',
                'display_name' => 'View',
                'description' => 'View & edit landing page',
                'module' => 'Website Management',
                'sub_module' => 'Landing Page',
                'group' => 'website_management',
                'sort_order' => 50,
            ],
            
            // About Us
            [
                'name' => 'website.about-us.view',
                'display_name' => 'View',
                'description' => 'View about us content',
                'module' => 'Website Management',
                'sub_module' => 'About Us',
                'group' => 'website_management',
                'sort_order' => 50,
            ],
            [
                'name' => 'website.about-us.create',
                'display_name' => 'Create',
                'description' => 'Add new about us item',
                'module' => 'Website Management',
                'sub_module' => 'About Us',
                'group' => 'website_management',
                'sort_order' => 50,
            ],
            [
                'name' => 'website.about-us.edit',
                'display_name' => 'Edit',
                'description' => 'Edit about us content',
                'module' => 'Website Management',
                'sub_module' => 'About Us',
                'group' => 'website_management',
                'sort_order' => 50,
            ],
            [
                'name' => 'website.about-us.delete',
                'display_name' => 'Delete',
                'description' => 'Delete about us item',
                'module' => 'Website Management',
                'sub_module' => 'About Us',
                'group' => 'website_management',
                'sort_order' => 50,
            ],
            
            // Hero Banners
            [
                'name' => 'website.banners.view',
                'display_name' => 'View',
                'description' => 'View hero banners',
                'module' => 'Website Management',
                'sub_module' => 'Hero Banners',
                'group' => 'website_management',
                'sort_order' => 50,
            ],
            [
                'name' => 'website.banners.create',
                'display_name' => 'Create',
                'description' => 'Add new hero banner',
                'module' => 'Website Management',
                'sub_module' => 'Hero Banners',
                'group' => 'website_management',
                'sort_order' => 50,
            ],
            [
                'name' => 'website.banners.edit',
                'display_name' => 'Edit',
                'description' => 'Edit hero banner',
                'module' => 'Website Management',
                'sub_module' => 'Hero Banners',
                'group' => 'website_management',
                'sort_order' => 50,
            ],
            [
                'name' => 'website.banners.delete',
                'display_name' => 'Delete',
                'description' => 'Delete hero banner',
                'module' => 'Website Management',
                'sub_module' => 'Hero Banners',
                'group' => 'website_management',
                'sort_order' => 50,
            ],
            
            // Collections
            [
                'name' => 'website.collections.view',
                'display_name' => 'View',
                'description' => 'View ebook collections',
                'module' => 'Website Management',
                'sub_module' => 'Collections',
                'group' => 'website_management',
                'sort_order' => 50,
            ],
            [
                'name' => 'website.collections.create',
                'display_name' => 'Create',
                'description' => 'Add new collection',
                'module' => 'Website Management',
                'sub_module' => 'Collections',
                'group' => 'website_management',
                'sort_order' => 50,
            ],
            [
                'name' => 'website.collections.edit',
                'display_name' => 'Edit',
                'description' => 'Edit collection',
                'module' => 'Website Management',
                'sub_module' => 'Collections',
                'group' => 'website_management',
                'sort_order' => 50,
            ],
            [
                'name' => 'website.collections.delete',
                'display_name' => 'Delete',
                'description' => 'Delete collection',
                'module' => 'Website Management',
                'sub_module' => 'Collections',
                'group' => 'website_management',
                'sort_order' => 50,
            ],
            
            // Contact Info
            [
                'name' => 'website.contact-info.view',
                'display_name' => 'View',
                'description' => 'View contact information',
                'module' => 'Website Management',
                'sub_module' => 'Contact Info',
                'group' => 'website_management',
                'sort_order' => 50,
            ],
            [
                'name' => 'website.contact-info.create',
                'display_name' => 'Create',
                'description' => 'Add new contact info',
                'module' => 'Website Management',
                'sub_module' => 'Contact Info',
                'group' => 'website_management',
                'sort_order' => 50,
            ],
            [
                'name' => 'website.contact-info.edit',
                'display_name' => 'Edit',
                'description' => 'Edit contact information',
                'module' => 'Website Management',
                'sub_module' => 'Contact Info',
                'group' => 'website_management',
                'sort_order' => 50,
            ],
            [
                'name' => 'website.contact-info.delete',
                'display_name' => 'Delete',
                'description' => 'Delete contact info',
                'module' => 'Website Management',
                'sub_module' => 'Contact Info',
                'group' => 'website_management',
                'sort_order' => 50,
            ],
            
            // Site Settings
            [
                'name' => 'website.site-settings',
                'display_name' => 'View',
                'description' => 'View & edit site settings',
                'module' => 'Website Management',
                'sub_module' => 'Site Settings',
                'group' => 'website_management',
                'sort_order' => 50,
            ],
        ];

        // Get all permission names that should exist
        $permissionNames = collect($permissions)->pluck('name')->toArray();

        // Update or create permissions
        foreach ($permissions as $permission) {
            AdminPermission::updateOrCreate(
                ['name' => $permission['name']],
                $permission
            );
        }

        // Delete permissions that are not in the list
        AdminPermission::whereNotIn('name', $permissionNames)->delete();

        $this->command->info('Admin permissions seeded successfully!');
        $this->command->info('Total permissions: ' . count($permissionNames));
    }
}
