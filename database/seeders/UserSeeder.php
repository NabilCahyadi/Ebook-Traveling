<?php

namespace Database\Seeders;

use App\Models\User;
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
        // Create Admin User
        User::create([
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

        // Create Superadmin User
        User::create([
            'id' => Str::uuid(),
            'name' => 'Super Admin',
            'email' => 'superadmin@ebook.com',
            'password' => Hash::make('password'),
            'user_type' => 'admin',
            'phone' => '+62812345679',
            'status' => 'active',
            'preferred_language' => 'id',
            'email_verified_at' => now(),
            'last_login_at' => now(),
        ]);

        // Create Customer Users
        User::create([
            'id' => Str::uuid(),
            'name' => 'John Doe',
            'email' => 'customer@ebook.com',
            'password' => Hash::make('password'),
            'user_type' => 'customer',
            'phone' => '+62823456789',
            'status' => 'active',
            'preferred_language' => 'en',
            'email_verified_at' => now(),
            'last_login_at' => now(),
        ]);

        User::create([
            'id' => Str::uuid(),
            'name' => 'Jane Smith',
            'email' => 'jane@example.com',
            'password' => Hash::make('password'),
            'user_type' => 'customer',
            'phone' => '+62834567890',
            'status' => 'active',
            'preferred_language' => 'en',
            'email_verified_at' => now(),
        ]);

        User::create([
            'id' => Str::uuid(),
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'password' => Hash::make('password'),
            'user_type' => 'customer',
            'phone' => '+62845678901',
            'status' => 'active',
            'preferred_language' => 'id',
            'email_verified_at' => now(),
        ]);

        User::create([
            'id' => Str::uuid(),
            'name' => 'Siti Nurhaliza',
            'email' => 'siti@example.com',
            'password' => Hash::make('password'),
            'user_type' => 'customer',
            'phone' => '+62856789012',
            'status' => 'active',
            'preferred_language' => 'id',
            'email_verified_at' => now(),
        ]);

        $this->command->info('✅ Users seeded successfully!');
        $this->command->info('📧 Admin: admin@ebook.com / password');
        $this->command->info('📧 Superadmin: superadmin@ebook.com / password');
        $this->command->info('📧 Customer: customer@ebook.com / password');
    }
}
