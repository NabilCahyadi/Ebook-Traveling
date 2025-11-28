<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin User
        User::updateOrCreate(
            ['email' => 'nabilcahyadi155@gmail.com'],
            [
                'id' => Str::uuid(),
                'name' => 'Nabil Cahyadi',
                'email' => 'nabilcahyadi155@gmail.com',
                'phone' => '081234567890',
                'password' => Hash::make('password123'),
                'user_type' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        $this->command->info('Admin user created successfully!');
        $this->command->info('Email: nabilcahyadi155@gmail.com');
        $this->command->info('Password: password123');
    }
}
