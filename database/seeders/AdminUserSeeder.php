<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get or create admin role
        $adminRole = Role::firstOrCreate(
            ['slug' => 'admin'],
            [
                'name' => 'Admin',
                'description' => 'Administrator with full access',
            ]
        );

        // Create admin user if not exists
        $admin = User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('123123123'),
                'user_type' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        // Sync admin role (akan replace role yang ada atau tambah baru)
        $admin->roles()->sync([$adminRole->id]);

        $this->command->info('Admin user created/updated successfully!');
        $this->command->info('Email: admin@gmail.com');
        $this->command->info('Password: 123123123');
        $this->command->info('Role: Admin');
    }
}
