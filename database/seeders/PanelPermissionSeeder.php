<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;

class PanelPermissionSeeder extends Seeder
{
    /**
     * Seed panel permissions (for dynamic user access like creators).
     * These are identical to admin permissions but with 'panel.' prefix.
     */
    public function run(): void
    {
        $permissions = [
            // ==================== PANEL ACCESS ====================
            ['name' => 'panel.access', 'display_name' => 'Access Management Panel', 'description' => 'Can access management panel', 'group' => 'Panel Access', 'module' => 'access'],
            
            // ==================== DASHBOARD MODULE ====================
            ['name' => 'panel.dashboard.view', 'display_name' => 'View Dashboard', 'description' => 'Can view panel dashboard', 'group' => 'Dashboard', 'module' => 'dashboard'],
            
            // ==================== USER MANAGEMENT MODULE ====================
            // Users Page
            ['name' => 'panel.users.view', 'display_name' => 'View Users Page', 'description' => 'Can access users list page', 'group' => 'User Management', 'module' => 'users'],
            ['name' => 'panel.users.create', 'display_name' => 'Create User', 'description' => 'Can create new user', 'group' => 'User Management', 'module' => 'users'],
            ['name' => 'panel.users.edit', 'display_name' => 'Edit User', 'description' => 'Can edit user', 'group' => 'User Management', 'module' => 'users'],
            ['name' => 'panel.users.delete', 'display_name' => 'Delete User', 'description' => 'Can delete user', 'group' => 'User Management', 'module' => 'users'],
            
            // Roles Page
            ['name' => 'panel.roles.view', 'display_name' => 'View Roles Page', 'description' => 'Can access roles list page', 'group' => 'User Management', 'module' => 'roles'],
            ['name' => 'panel.roles.edit', 'display_name' => 'Edit Role Permissions', 'description' => 'Can edit role permissions', 'group' => 'User Management', 'module' => 'roles'],
            
            // Activity Logs Page
            ['name' => 'panel.activity_logs.view', 'display_name' => 'View Activity Logs Page', 'description' => 'Can access activity logs page', 'group' => 'User Management', 'module' => 'activity_logs'],
            
            // ==================== EBOOK MANAGEMENT MODULE ====================
            // Ebooks Page
            ['name' => 'panel.ebooks.view', 'display_name' => 'View Ebooks Page', 'description' => 'Can access ebooks list page', 'group' => 'Ebook Management', 'module' => 'ebooks'],
            ['name' => 'panel.ebooks.create', 'display_name' => 'Create Ebook', 'description' => 'Can create new ebook', 'group' => 'Ebook Management', 'module' => 'ebooks'],
            ['name' => 'panel.ebooks.edit', 'display_name' => 'Edit Ebook', 'description' => 'Can edit ebook', 'group' => 'Ebook Management', 'module' => 'ebooks'],
            ['name' => 'panel.ebooks.delete', 'display_name' => 'Delete Ebook', 'description' => 'Can delete ebook', 'group' => 'Ebook Management', 'module' => 'ebooks'],
            
            // Categories Page
            ['name' => 'panel.categories.view', 'display_name' => 'View Categories Page', 'description' => 'Can access categories list page', 'group' => 'Ebook Management', 'module' => 'categories'],
            
            // Cities Page
            ['name' => 'panel.cities.view', 'display_name' => 'View Cities Page', 'description' => 'Can access cities list page', 'group' => 'Ebook Management', 'module' => 'cities'],
            
            // ==================== BLOG MANAGEMENT MODULE ====================
            // Blogs Page
            ['name' => 'panel.blogs.view', 'display_name' => 'View Blogs Page', 'description' => 'Can access blogs list page', 'group' => 'Blog Management', 'module' => 'blogs'],
            ['name' => 'panel.blogs.create', 'display_name' => 'Create Blog', 'description' => 'Can create new blog', 'group' => 'Blog Management', 'module' => 'blogs'],
            ['name' => 'panel.blogs.edit', 'display_name' => 'Edit Blog', 'description' => 'Can edit blog', 'group' => 'Blog Management', 'module' => 'blogs'],
            ['name' => 'panel.blogs.delete', 'display_name' => 'Delete Blog', 'description' => 'Can delete blog', 'group' => 'Blog Management', 'module' => 'blogs'],
        ];

        foreach ($permissions as $permission) {
            Permission::updateOrCreate(
                ['name' => $permission['name']],
                $permission
            );
        }
        
        $this->command->info('Panel permissions seeded successfully!');
    }
}
