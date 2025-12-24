<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;

class AdminPermissionSeeder extends Seeder
{
    /**
     * Seed admin panel permissions.
     */
    public function run(): void
    {
        $permissions = [
            // Dashboard
            ['name' => 'admin.dashboard.view', 'display_name' => 'View Dashboard', 'description' => 'Can view admin dashboard', 'group' => 'Dashboard', 'module' => 'dashboard'],
            
            // Ebook Management
            ['name' => 'admin.ebooks.view', 'display_name' => 'View Ebooks', 'description' => 'Can view ebooks list', 'group' => 'Ebook Management', 'module' => 'ebooks'],
            ['name' => 'admin.ebooks.create', 'display_name' => 'Create Ebook', 'description' => 'Can create new ebook', 'group' => 'Ebook Management', 'module' => 'ebooks'],
            ['name' => 'admin.ebooks.edit', 'display_name' => 'Edit Ebook', 'description' => 'Can edit existing ebook', 'group' => 'Ebook Management', 'module' => 'ebooks'],
            ['name' => 'admin.ebooks.delete', 'display_name' => 'Delete Ebook', 'description' => 'Can delete ebook', 'group' => 'Ebook Management', 'module' => 'ebooks'],
            ['name' => 'admin.ebooks.approve', 'display_name' => 'Approve Ebook', 'description' => 'Can approve/reject ebook', 'group' => 'Ebook Management', 'module' => 'ebooks'],
            
            // Category Management
            ['name' => 'admin.categories.view', 'display_name' => 'View Categories', 'description' => 'Can view categories list', 'group' => 'Category Management', 'module' => 'categories'],
            ['name' => 'admin.categories.create', 'display_name' => 'Create Category', 'description' => 'Can create new category', 'group' => 'Category Management', 'module' => 'categories'],
            ['name' => 'admin.categories.edit', 'display_name' => 'Edit Category', 'description' => 'Can edit existing category', 'group' => 'Category Management', 'module' => 'categories'],
            ['name' => 'admin.categories.delete', 'display_name' => 'Delete Category', 'description' => 'Can delete category', 'group' => 'Category Management', 'module' => 'categories'],
            
            // City Management
            ['name' => 'admin.cities.view', 'display_name' => 'View Cities', 'description' => 'Can view cities list', 'group' => 'City Management', 'module' => 'cities'],
            ['name' => 'admin.cities.create', 'display_name' => 'Create City', 'description' => 'Can create new city', 'group' => 'City Management', 'module' => 'cities'],
            ['name' => 'admin.cities.edit', 'display_name' => 'Edit City', 'description' => 'Can edit existing city', 'group' => 'City Management', 'module' => 'cities'],
            ['name' => 'admin.cities.delete', 'display_name' => 'Delete City', 'description' => 'Can delete city', 'group' => 'City Management', 'module' => 'cities'],
            
            // User Management
            ['name' => 'admin.users.view', 'display_name' => 'View Users', 'description' => 'Can view users list', 'group' => 'User Management', 'module' => 'users'],
            ['name' => 'admin.users.create', 'display_name' => 'Create User', 'description' => 'Can create new user', 'group' => 'User Management', 'module' => 'users'],
            ['name' => 'admin.users.edit', 'display_name' => 'Edit User', 'description' => 'Can edit existing user', 'group' => 'User Management', 'module' => 'users'],
            ['name' => 'admin.users.delete', 'display_name' => 'Delete User', 'description' => 'Can delete user', 'group' => 'User Management', 'module' => 'users'],
            
            // Role Management
            ['name' => 'admin.roles.view', 'display_name' => 'View Roles', 'description' => 'Can view roles list', 'group' => 'Role Management', 'module' => 'roles'],
            ['name' => 'admin.roles.create', 'display_name' => 'Create Role', 'description' => 'Can create new role', 'group' => 'Role Management', 'module' => 'roles'],
            ['name' => 'admin.roles.edit', 'display_name' => 'Edit Role', 'description' => 'Can edit existing role', 'group' => 'Role Management', 'module' => 'roles'],
            ['name' => 'admin.roles.delete', 'display_name' => 'Delete Role', 'description' => 'Can delete role', 'group' => 'Role Management', 'module' => 'roles'],
            
            // Permission Management
            ['name' => 'admin.permissions.view', 'display_name' => 'View Permissions', 'description' => 'Can view and manage role permissions', 'group' => 'Permission Management', 'module' => 'permissions'],
            ['name' => 'admin.permissions.assign', 'display_name' => 'Assign Permissions', 'description' => 'Can assign permissions to roles', 'group' => 'Permission Management', 'module' => 'permissions'],
            
            // Collection Management
            ['name' => 'admin.collections.view', 'display_name' => 'View Collections', 'description' => 'Can view collections list', 'group' => 'Collection Management', 'module' => 'collections'],
            ['name' => 'admin.collections.create', 'display_name' => 'Create Collection', 'description' => 'Can create new collection', 'group' => 'Collection Management', 'module' => 'collections'],
            ['name' => 'admin.collections.edit', 'display_name' => 'Edit Collection', 'description' => 'Can edit existing collection', 'group' => 'Collection Management', 'module' => 'collections'],
            ['name' => 'admin.collections.delete', 'display_name' => 'Delete Collection', 'description' => 'Can delete collection', 'group' => 'Collection Management', 'module' => 'collections'],
            
            // Banner Management
            ['name' => 'admin.banners.view', 'display_name' => 'View Banners', 'description' => 'Can view banners list', 'group' => 'Banner Management', 'module' => 'banners'],
            ['name' => 'admin.banners.create', 'display_name' => 'Create Banner', 'description' => 'Can create new banner', 'group' => 'Banner Management', 'module' => 'banners'],
            ['name' => 'admin.banners.edit', 'display_name' => 'Edit Banner', 'description' => 'Can edit existing banner', 'group' => 'Banner Management', 'module' => 'banners'],
            ['name' => 'admin.banners.delete', 'display_name' => 'Delete Banner', 'description' => 'Can delete banner', 'group' => 'Banner Management', 'module' => 'banners'],
            
            // Promo Management
            ['name' => 'admin.promos.view', 'display_name' => 'View Promos', 'description' => 'Can view promos list', 'group' => 'Promo Management', 'module' => 'promos'],
            ['name' => 'admin.promos.create', 'display_name' => 'Create Promo', 'description' => 'Can create new promo', 'group' => 'Promo Management', 'module' => 'promos'],
            ['name' => 'admin.promos.edit', 'display_name' => 'Edit Promo', 'description' => 'Can edit existing promo', 'group' => 'Promo Management', 'module' => 'promos'],
            ['name' => 'admin.promos.delete', 'display_name' => 'Delete Promo', 'description' => 'Can delete promo', 'group' => 'Promo Management', 'module' => 'promos'],
            
            // Subscription Management
            ['name' => 'admin.subscriptions.view', 'display_name' => 'View Subscriptions', 'description' => 'Can view subscriptions list', 'group' => 'Subscription Management', 'module' => 'subscriptions'],
            ['name' => 'admin.subscriptions.manage', 'display_name' => 'Manage Subscriptions', 'description' => 'Can manage user subscriptions', 'group' => 'Subscription Management', 'module' => 'subscriptions'],
            
            // Blog Management
            ['name' => 'admin.blogs.view', 'display_name' => 'View Blogs', 'description' => 'Can view blogs list', 'group' => 'Blog Management', 'module' => 'blogs'],
            ['name' => 'admin.blogs.create', 'display_name' => 'Create Blog', 'description' => 'Can create new blog', 'group' => 'Blog Management', 'module' => 'blogs'],
            ['name' => 'admin.blogs.edit', 'display_name' => 'Edit Blog', 'description' => 'Can edit existing blog', 'group' => 'Blog Management', 'module' => 'blogs'],
            ['name' => 'admin.blogs.delete', 'display_name' => 'Delete Blog', 'description' => 'Can delete blog', 'group' => 'Blog Management', 'module' => 'blogs'],
            
            // Settings
            ['name' => 'admin.settings.view', 'display_name' => 'View Settings', 'description' => 'Can view system settings', 'group' => 'Settings', 'module' => 'settings'],
            ['name' => 'admin.settings.edit', 'display_name' => 'Edit Settings', 'description' => 'Can edit system settings', 'group' => 'Settings', 'module' => 'settings'],
            
            // Activity Logs
            ['name' => 'admin.activity_logs.view', 'display_name' => 'View Activity Logs', 'description' => 'Can view activity logs', 'group' => 'Activity Logs', 'module' => 'activity_logs'],
        ];

        foreach ($permissions as $permission) {
            Permission::updateOrCreate(
                ['name' => $permission['name']],
                $permission
            );
        }
        
        $this->command->info('Admin permissions seeded successfully!');
    }
}
