<?php

namespace Database\Seeders\Development;

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
        $readerRole = Role::where('slug', 'reader')->first();
        $creatorRole = Role::where('slug', 'creator')->first();

        if (!$readerRole || !$creatorRole) {
            $this->command->error('❌ Roles not found! Please run RoleSeeder first.');
            return;
        }

        // Create 10 Reader Users (free_user)
        for ($i = 1; $i <= 10; $i++) {
            $reader = User::create([
                'id' => Str::uuid(),
                'name' => 'Reader ' . $i,
                'email' => 'reader' . $i . '@ebook.com',
                'password' => Hash::make('password'),
                'user_type' => 'free_user', // subscription status
                'phone' => '+6281' . str_pad($i, 8, '0', STR_PAD_LEFT),
                'status' => 'active',
                'preferred_language' => $i % 2 == 0 ? 'en' : 'id',
                'email_verified_at' => now(),
                'last_login_at' => now(),
            ]);

            // Assign reader role via user_roles pivot table
            UserRole::create([
                'user_id' => $reader->id,
                'role_id' => $readerRole->id,
            ]);
        }

        $this->command->info('✅ 10 Readers created (free users)');

        // Create 10 Creator Users (member)
        for ($i = 1; $i <= 10; $i++) {
            $creator = User::create([
                'id' => Str::uuid(),
                'name' => 'Creator ' . $i,
                'email' => 'creator' . $i . '@ebook.com',
                'password' => Hash::make('password'),
                'user_type' => 'member', // subscription status
                'phone' => '+6282' . str_pad($i, 8, '0', STR_PAD_LEFT),
                'status' => 'active',
                'preferred_language' => $i % 2 == 0 ? 'en' : 'id',
                'email_verified_at' => now(),
                'last_login_at' => now(),
            ]);

            // Assign creator role via user_roles pivot table
            UserRole::create([
                'user_id' => $creator->id,
                'role_id' => $creatorRole->id,
            ]);
        }

        $this->command->info('✅ 10 Creators created (premium members)');

        // Create 2 users with multiple roles (Reader + Creator)
        for ($i = 1; $i <= 2; $i++) {
            $multiRole = User::create([
                'id' => Str::uuid(),
                'name' => 'Multi Role User ' . $i,
                'email' => 'multirole' . $i . '@ebook.com',
                'password' => Hash::make('password'),
                'user_type' => 'member', // subscription status
                'phone' => '+6283' . str_pad($i, 8, '0', STR_PAD_LEFT),
                'status' => 'active',
                'preferred_language' => 'en',
                'email_verified_at' => now(),
                'last_login_at' => now(),
            ]);

            // Assign both reader and creator roles
            UserRole::create([
                'user_id' => $multiRole->id,
                'role_id' => $readerRole->id,
            ]);
            UserRole::create([
                'user_id' => $multiRole->id,
                'role_id' => $creatorRole->id,
            ]);
        }

        $this->command->info('✅ 2 Multi-role users created (Reader + Creator)');

        $this->command->info('');
        $this->command->info('=== User Credentials ===');
        $this->command->info('📚 Readers: reader1@ebook.com to reader10@ebook.com / password');
        $this->command->info('✍️  Creators: creator1@ebook.com to creator10@ebook.com / password');
        $this->command->info('🎭 Multi-role: multirole1@ebook.com to multirole2@ebook.com / password');
        $this->command->info('');
        $this->command->info('Total: 22 users created');
        $this->command->info('  - 10 Readers (free_user)');
        $this->command->info('  - 10 Creators (member)');
        $this->command->info('  -  2 Multi-role users (member with both roles)');
    }
}
