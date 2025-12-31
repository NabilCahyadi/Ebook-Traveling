<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class CreatorUserSeeder extends Seeder
{
    /**
     * Seed a creator test user.
     */
    public function run(): void
    {
        $creatorRole = Role::where('slug', 'creator')->first();

        if (!$creatorRole) {
            $this->command->error('Creator role not found. Please run RoleSeeder first!');
            return;
        }

        // Check if creator user already exists
        $existingUser = User::where('email', 'creator@gmail.com')->first();
        if ($existingUser) {
            $this->command->info('Creator user already exists: creator@gmail.com');
            return;
        }

        $user = User::create([
            'name' => 'Creator Test',
            'email' => 'creator@gmail.com',
            'password' => Hash::make('password'),
            'user_type' => 'creator',
            'status' => 'active',
            'email_verified_at' => now(),
        ]);

        $this->command->info('✅ Creator user created successfully!');
        $this->command->info('   Email: creator@gmail.com');
        $this->command->info('   Password: password');
        $this->command->info('   Role: Creator');
        $this->command->info('   Login URL: /panel/login');
    }
}
