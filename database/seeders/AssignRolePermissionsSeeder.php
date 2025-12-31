<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Support\Facades\DB;

class AssignRolePermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * KONSEP PERMISSION:
     * 
     * 1. FRONT-END (Hardcode di code, TIDAK perlu database permission):
     *    - Member (Premium user)
     *    - Free User  
     *    - Guest
     *    → Permission check via: auth()->check(), isPremium(), subscription status, dll
     * 
     * 2. ADMIN PANEL (Dynamic dari database):
     *    - Admin: Full access admin panel
     *    - Creator: Limited admin panel (manage own ebooks)
     *    → Permission check via: hasPermission('admin.xxx')
     * 
     * Seeder ini HANYA assign permission untuk Admin & Creator (yang akses admin panel).
     * Member, Free User, Guest TIDAK perlu permission di database.
     */
    public function run(): void
    {
        $this->command->info('Starting role permission assignment...');
        $this->command->info('NOTE: Only assigning permissions for Admin & Creator roles.');
        $this->command->info('Member, Free User, Guest use hardcoded permissions in code.');

        // Clear existing role-permission assignments
        DB::table('role_permission')->truncate();

        // Get admin panel roles only
        $adminRole = Role::where('slug', 'admin')->first();
        $creatorRole = Role::where('slug', 'creator')->first();

        if (!$adminRole || !$creatorRole) {
            $this->command->error('Admin or Creator role is missing. Please run RoleSeeder first!');
            return;
        }

        // ==================== ADMIN ROLE ====================
        $this->command->info('Assigning permissions to Admin role...');
        $adminPermissions = [
            // Panel Access
            'panel.access',
            
            // Dashboard
            'admin.dashboard.view',
            
            // Ebook Management - Full access
            'admin.ebooks.view',
            'admin.ebooks.create',
            'admin.ebooks.edit',
            'admin.ebooks.delete',
            'admin.ebooks.approve',
            
            // Category Management
            'admin.categories.view',
            'admin.categories.create',
            'admin.categories.edit',
            'admin.categories.delete',
            
            // City Management
            'admin.cities.view',
            'admin.cities.create',
            'admin.cities.edit',
            'admin.cities.delete',
            
            // User Management
            'admin.users.view',
            'admin.users.create',
            'admin.users.edit',
            'admin.users.delete',
            
            // Role Management
            'admin.roles.view',
            'admin.roles.create',
            'admin.roles.edit',
            'admin.roles.delete',
            
            // Permission Management
            'admin.permissions.view',
            'admin.permissions.assign',
            
            // Collection Management
            'admin.collections.view',
            'admin.collections.create',
            'admin.collections.edit',
            'admin.collections.delete',
            
            // Banner Management
            'admin.banners.view',
            'admin.banners.create',
            'admin.banners.edit',
            'admin.banners.delete',
            
            // Promo Management
            'admin.promos.view',
            'admin.promos.create',
            'admin.promos.edit',
            'admin.promos.delete',
            
            // Subscription Management
            'admin.subscriptions.view',
            'admin.subscriptions.manage',
            
            // Blog Management
            'admin.blogs.view',
            'admin.blogs.create',
            'admin.blogs.edit',
            'admin.blogs.delete',
            
            // Settings
            'admin.settings.view',
            'admin.settings.edit',
            
            // Activity Logs
            'admin.activity_logs.view',
        ];
        $this->assignPermissions($adminRole, $adminPermissions);

        // ==================== CREATOR ROLE ====================
        $this->command->info('Assigning permissions to Creator role...');
        $creatorPermissions = [
            // Panel dashboard access
            'panel.dashboard.view',
            
            // Ebook management (own ebooks only)
            'panel.ebooks.view',
            'panel.ebooks.create',
            'panel.ebooks.edit',  // Note: Controller should limit to own ebooks
            'panel.ebooks.delete', // Note: Controller should limit to own ebooks
            
            // View categories and cities (for tagging)
            'panel.categories.view',
            'panel.cities.view',
            
            // Blog management (own blogs only)
            'panel.blogs.view',
            'panel.blogs.create',
            'panel.blogs.edit',
            'panel.blogs.delete',
        ];
        $this->assignPermissions($creatorRole, $creatorPermissions);

        // ==================== FRONT-END ROLES ====================
        // Member, Free User, dan Guest TIDAK perlu permission di database.
        // Mereka menggunakan HARDCODED permission checks di code:
        // - auth()->check() - User logged in?
        // - auth()->user()->isPremium() - Is premium member?
        // - Subscription status checks
        // - Feature flags, etc.
        
        $this->command->info('');
        $this->command->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        $this->command->info('📌 IMPORTANT NOTE:');
        $this->command->info('Member, Free User, and Guest roles DO NOT need database permissions.');
        $this->command->info('Their permissions are HARDCODED in the application logic:');
        $this->command->info('  - Check via: auth()->check(), isPremium(), subscription status');
        $this->command->info('  - Example: if($user->isPremium()) { allow download; }');
        $this->command->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        $this->command->info('');

        $this->command->info('✅ Role permissions assigned successfully!');
    }

    /**
     * Assign permissions to a role.
     * 
     * @param Role $role
     * @param array $permissionNames
     */
    private function assignPermissions(Role $role, array $permissionNames): void
    {
        $permissionIds = Permission::whereIn('name', $permissionNames)->pluck('id')->toArray();
        
        if (count($permissionIds) !== count($permissionNames)) {
            $foundPermissions = Permission::whereIn('name', $permissionNames)->pluck('name')->toArray();
            $missingPermissions = array_diff($permissionNames, $foundPermissions);
            
            if (!empty($missingPermissions)) {
                $this->command->warn("⚠️  Missing permissions for {$role->name}: " . implode(', ', $missingPermissions));
            }
        }
        
        $role->permissions()->sync($permissionIds);
        $this->command->info("   → {$role->name}: " . count($permissionIds) . " permissions assigned");
    }
}
