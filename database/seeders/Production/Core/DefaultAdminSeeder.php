<?php

namespace Database\Seeders\Production\Core;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class DefaultAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Creates default admin and superadmin accounts.
     */
    public function run(): void
    {
        $this->command->info('Creating default admin accounts...');

        // Create regular admin
        $admin = Admin::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('123123123'),
                'type' => 'admin',
                'status' => 'active',
                'email_verified_at' => now(),
            ]
        );

        $this->command->info('✓ Admin created: admin@gmail.com (password: 123123123)');

        // Create superadmin
        $superadmin = Admin::updateOrCreate(
            ['email' => 'superadmin@gmail.com'],
            [
                'name' => 'Super Admin',
                'email' => 'superadmin@gmail.com',
                'password' => Hash::make('123123123'),
                'type' => 'superadmin',
                'status' => 'active',
                'email_verified_at' => now(),
            ]
        );

        $this->command->info('✓ Superadmin created: superadmin@gmail.com (password: 123123123)');

        $this->command->info("\n=================================");
        $this->command->info("Default Admin Accounts Created!");
        $this->command->info("=================================");
        $this->command->info("Admin:");
        $this->command->info("  Email: admin@gmail.com");
        $this->command->info("  Password: 123123123");
        $this->command->info("  Type: admin");
        $this->command->info("\nSuperadmin:");
        $this->command->info("  Email: superadmin@gmail.com");
        $this->command->info("  Password: 123123123");
        $this->command->info("  Type: superadmin");
        $this->command->info("=================================\n");
    }
}
