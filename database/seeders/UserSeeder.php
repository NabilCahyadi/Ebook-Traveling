<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use App\Models\UserRole;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get roles
        $adminRole = Role::where('slug', 'admin')->first();
        $creatorRole = Role::where('slug', 'creator')->first();
        $memberRole = Role::where('slug', 'member')->first();

        // Create 1 Admin User
        $admin = User::create([
            'id' => Str::uuid(),
            'name' => 'Admin Ebook Traveling',
            'email' => 'admin@ebook.com',
            'password' => Hash::make('password'),
            'user_type' => 'admin',
            'phone' => '+62812345678',
            'status' => 'active',
            'preferred_language' => 'id',
            'email_verified_at' => now(),
            'last_login_at' => now(),
        ]);

        // Assign admin role
        if ($adminRole) {
            UserRole::create([
                'user_id' => $admin->id,
                'role_id' => $adminRole->id,
            ]);
        }

        $this->command->info('✅ 1 Admin created');

        // Create 10 Creator Users
        for ($i = 1; $i <= 10; $i++) {
            $creator = User::create([
                'id' => Str::uuid(),
                'name' => 'Creator ' . $i,
                'email' => 'creator' . $i . '@ebook.com',
                'password' => Hash::make('password'),
                'user_type' => 'creator',
                'phone' => '+6281' . str_pad($i, 8, '0', STR_PAD_LEFT),
                'status' => 'active',
                'preferred_language' => $i % 2 == 0 ? 'en' : 'id',
                'email_verified_at' => now(),
                'last_login_at' => now(),
            ]);

            // Assign creator role
            if ($creatorRole) {
                UserRole::create([
                    'user_id' => $creator->id,
                    'role_id' => $creatorRole->id,
                ]);
            }
        }

        $this->command->info('✅ 10 Creators created');

        // Create 10 Member Users
        for ($i = 1; $i <= 10; $i++) {
            $member = User::create([
                'id' => Str::uuid(),
                'name' => 'Member ' . $i,
                'email' => 'member' . $i . '@ebook.com',
                'password' => Hash::make('password'),
                'user_type' => 'member',
                'phone' => '+6282' . str_pad($i, 8, '0', STR_PAD_LEFT),
                'status' => 'active',
                'preferred_language' => $i % 2 == 0 ? 'en' : 'id',
                'email_verified_at' => now(),
                'last_login_at' => now(),
            ]);

            // Assign member role
            if ($memberRole) {
                UserRole::create([
                    'user_id' => $member->id,
                    'role_id' => $memberRole->id,
                ]);
            }
        }

        $this->command->info('✅ 10 Members created');

        $this->command->info('');
        $this->command->info('=== User Credentials ===');
        $this->command->info('📧 Admin: admin@ebook.com / password');
        $this->command->info('📧 Creators: creator1@ebook.com to creator10@ebook.com / password');
        $this->command->info('📧 Members: member1@ebook.com to member10@ebook.com / password');
        $this->command->info('');
        $this->command->info('Total: 21 users created (1 Admin + 10 Creators + 10 Members)');
    }
}
