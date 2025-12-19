<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class GuestRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if Guest role already exists
        $guestRole = DB::table('roles')->where('slug', 'guest')->first();

        if (!$guestRole) {
            // Create Guest role
            $roleId = Str::uuid();
            
            DB::table('roles')->insert([
                'id' => $roleId,
                'name' => 'Guest',
                'slug' => 'guest',
                'description' => 'Guest user (not logged in). Configure which pages guests can access.',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Give Guest role default permissions (all navigation access)
            $defaultPermissions = [
                'access_home',
                'access_destinations',
                'access_blog',
                'access_pricing',
                'access_promo',
                'view_ebook_library',
            ];

            $permissions = DB::table('permissions')
                ->whereIn('name', $defaultPermissions)
                ->get();

            foreach ($permissions as $permission) {
                DB::table('role_permission')->insert([
                    'role_id' => $roleId,
                    'permission_id' => $permission->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            $this->command->info('Guest role created with default permissions.');
        } else {
            $this->command->info('Guest role already exists.');
        }
    }
}
