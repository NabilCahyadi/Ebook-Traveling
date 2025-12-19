<?php

namespace App\Services;

use App\Models\Role;
use App\Repositories\Interfaces\PermissionRepositoryInterface;

class RolePermissionService
{
    protected $permissionRepository;

    public function __construct(PermissionRepositoryInterface $permissionRepository)
    {
        $this->permissionRepository = $permissionRepository;
    }

    public function getAllRolesWithPermissions()
    {
        return Role::with('permissions')
            ->whereNotIn('slug', ['admin'])
            ->orderByRaw("CASE WHEN slug = 'guest' THEN 0 ELSE 1 END")
            ->orderBy('name')
            ->get();
    }

    public function updateRolePermissions(Role $role, array $permissionNames)
    {
        $permissions = $this->permissionRepository->findByNames($permissionNames);
        $role->permissions()->sync($permissions->pluck('id'));
    }

    public function getPermissionModules()
    {
        return [
            [
                'name' => 'Navigation & Pages',
                'permissions' => [
                    ['name' => 'access_home', 'label' => 'Access Home Page'],
                    ['name' => 'access_destinations', 'label' => 'Access Destinations Page'],
                    ['name' => 'access_blog', 'label' => 'Access Blog Page'],
                    ['name' => 'access_pricing', 'label' => 'Access Pricing Page'],
                    ['name' => 'access_promo', 'label' => 'Access Promo Page'],
                ]
            ],
            // [
            //     'name' => 'Ebook Features',
            //     'permissions' => [
            //         ['name' => 'view_ebook_library', 'label' => 'View Ebook Library'],
            //         ['name' => 'read_ebook', 'label' => 'Read Ebooks'],
            //         ['name' => 'download_ebook', 'label' => 'Download Ebooks'],
            //         ['name' => 'rate_ebook', 'label' => 'Rate & Review Ebooks'],
            //         ['name' => 'bookmark_ebook', 'label' => 'Bookmark Ebooks'],
            //     ]
            // ],
            // [
            //     'name' => 'Creator Features',
            //     'permissions' => [
            //         ['name' => 'upload_ebook', 'label' => 'Upload New Ebook'],
            //         ['name' => 'edit_own_ebook', 'label' => 'Edit Own Ebooks'],
            //         ['name' => 'delete_own_ebook', 'label' => 'Delete Own Ebooks'],
            //         ['name' => 'view_ebook_analytics', 'label' => 'View Ebook Analytics'],
            //     ]
            // ],
            // [
            //     'name' => 'Shopping & Payment',
            //     'permissions' => [
            //         ['name' => 'add_to_cart', 'label' => 'Add Items to Cart'],
            //         ['name' => 'checkout', 'label' => 'Checkout & Payment'],
            //         ['name' => 'use_promo_code', 'label' => 'Use Promo Codes'],
            //         ['name' => 'view_order_history', 'label' => 'View Order History'],
            //     ]
            // ],
            // [
            //     'name' => 'Subscription Features',
            //     'permissions' => [
            //         ['name' => 'subscribe', 'label' => 'Subscribe to Plans'],
            //         ['name' => 'manage_subscription', 'label' => 'Manage Own Subscription'],
            //         ['name' => 'cancel_subscription', 'label' => 'Cancel Subscription'],
            //         ['name' => 'upgrade_subscription', 'label' => 'Upgrade Subscription Plan'],
            //     ]
            // ],
            // [
            //     'name' => 'Profile & Settings',
            //     'permissions' => [
            //         ['name' => 'edit_profile', 'label' => 'Edit Profile'],
            //         ['name' => 'change_password', 'label' => 'Change Password'],
            //         ['name' => 'delete_account', 'label' => 'Delete Own Account'],
            //         ['name' => 'view_notifications', 'label' => 'View Notifications'],
            //     ]
            // ],
            // [
            //     'name' => 'Social Features',
            //     'permissions' => [
            //         ['name' => 'comment_blog', 'label' => 'Comment on Blogs'],
            //         ['name' => 'share_content', 'label' => 'Share Content'],
            //         ['name' => 'follow_creators', 'label' => 'Follow Creators'],
            //     ]
            // ],
            // [
            //     'name' => 'Collections',
            //     'permissions' => [
            //         ['name' => 'view_collections', 'label' => 'View Collections'],
            //         ['name' => 'create_collection', 'label' => 'Create Own Collections'],
            //         ['name' => 'add_to_collection', 'label' => 'Add Ebooks to Collections'],
            //     ]
            // ],
            [
                'name' => 'Account Dashboard',
                'permissions' => [
                    ['name' => 'access_wishlist', 'label' => 'Wishlist Menu'],
                    ['name' => 'access_creator_dashboard', 'label' => 'Creator Dashboard Menu'],
                    ['name' => 'access_profile_settings', 'label' => 'Profile Settings Menu'],
                    ['name' => 'access_payment_history', 'label' => 'Payment History Menu'],
                ]
            ],
            [
                'name' => 'Company',
                'permissions' => [
                    ['name' => 'access_about_us', 'label' => 'About Us Page'],
                    ['name' => 'access_terms_conditions', 'label' => 'Terms & Conditions Page'],
                    ['name' => 'access_contact_us', 'label' => 'Contact Us Page'],
                    ['name' => 'access_help_center', 'label' => 'Help Center Page'],
                    ['name' => 'access_privacy_policy', 'label' => 'Privacy Policy Page'],
                    ['name' => 'access_shopping_policy', 'label' => 'Shopping Policy Page'],
                    ['name' => 'access_payment_policy', 'label' => 'Payment Policy Page'],
                    ['name' => 'access_faq', 'label' => 'FAQ Page'],
                ]
            ],
        ];
    }
}
