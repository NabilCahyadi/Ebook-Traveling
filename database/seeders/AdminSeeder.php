<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Migrate existing admin users from users table to admins table
     */
    public function run(): void
    {
        $this->command->info('Migrating admin users from users to admins table...');

        // Get all users with user_type = admin
        $adminUsers = User::where('user_type', 'admin')->get();

        if ($adminUsers->isEmpty()) {
            $this->command->warn('No admin users found in users table.');
            
            // Create default admin if none exists
            $this->createDefaultAdmin();
            return;
        }

        $migratedCount = 0;
        
        foreach ($adminUsers as $user) {
            // Check if admin already exists
            $existingAdmin = Admin::where('email', $user->email)->first();
            
            if ($existingAdmin) {
                $this->command->warn("Admin with email {$user->email} already exists. Skipping...");
                continue;
            }

            // Create admin record
            Admin::create([
                'id' => $user->id, // Keep same UUID
                'name' => $user->name,
                'email' => $user->email,
                'password' => $user->password, // Already hashed
                'avatar' => $user->avatar,
                'phone' => $user->phone,
                'status' => $user->status,
                'type' => 'admin', // Default type
                'email_verified_at' => $user->email_verified_at,
                'last_login_at' => $user->last_login_at,
                'remember_token' => $user->remember_token,
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at,
            ]);

            $migratedCount++;
            $this->command->info("✓ Migrated: {$user->name} ({$user->email})");
        }

        $this->command->info("\n=================================");
        $this->command->info("Migration completed!");
        $this->command->info("Total admins migrated: {$migratedCount}");
        $this->command->info("=================================\n");
        
        if ($migratedCount > 0) {
            $this->command->warn("IMPORTANT: After confirming admin login works, you should delete admin users from users table:");
            $this->command->warn("DELETE FROM users WHERE user_type = 'admin';");
        }
    }

    /**
     * Create default admin if no admin exists
     */
    private function createDefaultAdmin(): void
    {
        Admin::create([
            'id' => Str::uuid(),
            'name' => 'Admin',
            'email' => 'admin@ebook.com',
            'password' => Hash::make('password123'),
            'phone' => '081234567890',
            'status' => 'active',
            'type' => 'admin',
            'email_verified_at' => now(),
        ]);

        $this->command->info('✓ Default admin created successfully!');
        $this->command->info('Email: admin@ebook.com');
        $this->command->info('Password: password123');
    }
}
